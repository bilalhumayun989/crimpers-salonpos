<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\ServicePackage;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ProductUsage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Staff;

class POSController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $services = Service::all();
        $products = Product::where('current_stock', '>', 0)->get();
        $packages = ServicePackage::where('is_active', true)->get();
        $popularServices = Service::where('is_popular', true)->get();

        return view('pos.index', compact('categories', 'services', 'products', 'packages', 'popularServices'));
    }

    public function payment()
    {
        $staff = Staff::available()->get()->filter(function($s) {
            return $s->is_on_shift;
        });
        return view('pos.payment', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric',
            'payable_amount' => 'required|numeric',
            'customer_id' => 'nullable|exists:customers,id',
            'discount' => 'nullable|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            $customerId = $request->customer_id;
            
            // Auto-lookup/create customer based on phone (Unique identifier)
            if (!$customerId && $request->customer_phone) {
                // Sanitize phone for strict matching (remove spaces/dashes)
                $cleanPhone = preg_replace('/[^0-9]/', '', $request->customer_phone);
                
                // We check if THIS EXACT PHONE exists (using both raw and cleaned search)
                $customer = Customer::where('phone', $request->customer_phone)
                                    ->orWhere(DB::raw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '')"), $cleanPhone)
                                    ->first();
                
                if ($customer) {
                    $customerId = $customer->id;
                    // Optional: sync name if it's not a generic walk-in
                    if ($request->customer_name && $request->customer_name !== 'Walk-in Customer') {
                        $customer->update(['name' => $request->customer_name]);
                    }
                } else if ($request->customer_name && $request->customer_name !== 'Walk-in Customer') {
                    // NO customer found -> CREATE NEW
                    $newCustomer = Customer::create([
                        'name' => $request->customer_name,
                        'phone' => $request->customer_phone,
                        'membership_type' => 'Standard'
                    ]);
                    $customerId = $newCustomer->id;
                }
            }

            $invoice = Invoice::create([
                'invoice_no' => 'INV-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id() ?? 1, // Fallback for dev
                'customer_id' => $customerId,
                'total_amount' => $request->total_amount,
                'tax' => $request->tax ?? 0,
                'discount' => $request->discount ?? 0,
                'payable_amount' => $request->payable_amount,
                'payment_method' => $request->payment_method,
                'cash_received' => $request->cash_received,
                'change_returned' => $request->change_returned,
                'status' => 'paid',
            ]);

            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'itemizable_id' => $item['id'],
                    'itemizable_type' => $item['type'] === 'service' ? Service::class : ($item['type'] === 'package' ? ServicePackage::class : Product::class),
                    'custom_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update Staff HRMS Data if staff selected
                if ($request->staff_id) {
                    $performer = Staff::find($request->staff_id);
                    if ($performer) {
                        // Add commission if it's a service or package
                        if ($item['type'] === 'service' || $item['type'] === 'package') {
                            $performer->increment('total_earned_commission', ($performer->commission_per_service * $item['quantity']));
                        }
                    }
                }

                if ($item['type'] === 'product') {
                    $product = Product::find($item['id']);
                    $product->decrement('current_stock', $item['quantity']);

                    // Track product usage
                    ProductUsage::create([
                        'product_id' => $item['id'],
                        'invoice_id' => $invoice->id,
                        'quantity_used' => $item['quantity'],
                        'usage_date' => now(),
                        'notes' => 'Sold via POS'
                    ]);
                } elseif ($item['type'] === 'service') {
                    // Auto-deduct service supplies if configured
                    $this->deductServiceSupplies($item['id'], $item['quantity'], $invoice->id);
                } elseif ($item['type'] === 'package') {
                    // Handle package services and their supplies
                    $package = ServicePackage::with('services')->find($item['id']);
                    if ($package) {
                        foreach ($package->services as $service) {
                            $this->deductServiceSupplies($service->id, $item['quantity'], $invoice->id);
                        }
                    }
                }
            }

            // Update Staff Rating once per invoice
            if ($request->staff_id && $request->rating) {
                $performer = Staff::find($request->staff_id);
                if ($performer) {
                    $performer->increment('rating_total', (int)$request->rating);
                    $performer->increment('rating_count');
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice generated successfully',
                'invoice' => $invoice->load('items.itemizable'),
            ]);
        });
    }

    private function deductServiceSupplies($serviceId, $quantity, $invoiceId)
    {
        // Get service supplies that need to be auto-deducted
        $serviceSupplies = \App\Models\ServiceSupply::where('service_id', $serviceId)
            ->where('is_active', true)
            ->with('product')
            ->get();

        foreach ($serviceSupplies as $supply) {
            $product = $supply->product;
            $totalQuantity = $supply->quantity_per_service * $quantity;

            // Check if product tracks inventory and has sufficient stock
            if ($product && $product->track_inventory && $product->current_stock >= $totalQuantity) {
                // Deduct from inventory
                $product->decrement('current_stock', $totalQuantity);

                // Track product usage
                ProductUsage::create([
                    'product_id' => $product->id,
                    'service_id' => $serviceId,
                    'invoice_id' => $invoiceId,
                    'quantity_used' => $totalQuantity,
                    'usage_date' => now(),
                    'notes' => 'Auto-deducted for service performance'
                ]);
            } else {
                // Log insufficient stock or skip deduction
                // You might want to add logging here or notify staff
                Log::warning("Insufficient stock for auto-deduction: Product {$product->name} needs {$totalQuantity} units, has {$product->current_stock}");
            }
        }
    }

    public function checkCoupon(Request $request)
    {
        $code = $request->input('code');
        $totalAmount = $request->input('total_amount', 0);
        
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found']);
        }

        if (!$coupon->isValid(null, $totalAmount)) {
            return response()->json(['success' => false, 'message' => 'Coupon is not valid or requirements not met']);
        }

        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type, // fixed or percentage
                'value' => $coupon->value,
                'name' => $coupon->name
            ]
        ]);
    }

    public function searchCustomer(Request $request)
    {
        $q = $request->input('q');
        $name = $request->input('name');
        $phone = $request->input('phone');
        
        if (empty($q) && empty($name) && empty($phone)) {
            return response()->json(['success' => false, 'message' => 'Query is empty']);
        }

        $query = Customer::query();

        // 1. Prioritize Phone Search (Primary Key in business logic)
        if ($phone) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            $query->where(function($sub) use ($phone, $cleanPhone) {
                $sub->where('phone', $phone)
                    ->orWhere(DB::raw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '')"), $cleanPhone);
            });
        } 
        // 2. If no phone, or as a secondary filter, search by Name
        elseif ($name && $name !== 'Walk-in Customer') {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        // 3. General query fallback
        elseif ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('phone', 'LIKE', "%{$q}%")
                    ->orWhere('name', 'LIKE', "%{$q}%");
            });
        }

        $customer = $query->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found']);
        }

        $hasMembership = $customer->membership_status === 'Active';
        // Assume VIP/membership gives 10% discount for demo purposes, unless otherwise specified in your logic
        $discountPercent = 0;
        if ($hasMembership) {
            $discountPercent = stripos($customer->membership_type, 'VIP') !== false ? 15 : 10;
        }

        $totalSpent = $customer->invoices()->sum('payable_amount');
        $lastInvoice = $customer->invoices()->latest()->first();
        $lastVisit = $lastInvoice ? $lastInvoice->created_at->format('d M, Y') : null;

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'membership_type' => $customer->membership_type,
                'membership_status' => $customer->membership_status,
                'discount_percent' => $discountPercent,
                'total_spent' => $totalSpent,
                'last_visit' => $lastVisit
            ]
        ]);
    }
}
