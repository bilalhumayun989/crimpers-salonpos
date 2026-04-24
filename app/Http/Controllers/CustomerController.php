<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(12);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
        $appointments = $customer->appointments()->with('service')->latest()->get();
        $invoices = $customer->invoices()->latest()->get();
        
        return view('customers.show', compact('customer', 'appointments', 'invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
            'social_media' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'phone', 'social_media', 'email', 'notes']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('customers', 'public');
        }

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
            'social_media' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'phone', 'social_media', 'email', 'notes']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customer->image_path) {
                Storage::disk('public')->delete($customer->image_path);
            }
            $data['image_path'] = $request->file('image')->store('customers', 'public');
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->image_path) {
            Storage::disk('public')->delete($customer->image_path);
        }
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.'
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->query('term');
        $customers = Customer::where('name', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['name', 'phone']);

        return response()->json($customers);
    }
}
