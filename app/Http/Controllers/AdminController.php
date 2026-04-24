<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\StaffAttendance;
use App\Models\Coupon;
use App\Models\DiscountRule;
use App\Models\CashReconciliation;
use App\Models\Staff;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');

        // Auto-cancel late appointments
        Appointment::autoCancelLate();
        \App\Models\StaffAttendance::autoCheckout();
        
        $totalSalesToday = Invoice::whereDate('created_at', Carbon::today())->sum('payable_amount');
        $totalAppointmentsToday = Appointment::where('appointment_date', $today)->count();
        $completedAppointmentsToday = Appointment::where('appointment_date', $today)->where('status', 'completed')->count();

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $totalSalesWeek = Invoice::whereBetween('created_at', [$weekStart, $weekEnd])->sum('payable_amount');
        $totalAppointmentsWeek = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])->count();

        $totalRevenue      = Invoice::sum('payable_amount');
        $totalAppointments = Appointment::count();
        $totalCustomers    = Customer::count();
        $totalUsers        = User::count();

        // Product / inventory stats
        $totalProducts      = Product::count();
        $lowStockProducts   = Product::where('track_inventory', true)
                                ->whereColumn('current_stock', '<=', 'min_stock_level')
                                ->count();
        $outOfStockProducts = Product::where('track_inventory', true)
                                ->where('current_stock', '<=', 0)
                                ->count();
        $inventoryValue     = (float) Product::where('track_inventory', true)
                                ->selectRaw('SUM(current_stock * COALESCE(cost_price, 0)) as val')
                                ->value('val');
        
        $inventoryValueSell = (float) Product::where('track_inventory', true)
                                ->selectRaw('SUM(current_stock * COALESCE(selling_price, 0)) as val')
                                ->value('val');

        $lowStockList = Product::where('track_inventory', true)
                        ->whereColumn('current_stock', '<=', 'min_stock_level')
                        ->orderBy('current_stock')
                        ->take(6)->get();

        $recentAppointments = Appointment::with(['staff', 'service'])->latest()->take(5)->get();
        $lateAppointments = Appointment::where('status', 'cancelled')
                            ->where('appointment_date', $today)
                            ->where('notes', 'like', '%[System: Auto-discarded]%')
                            ->get();
        $recentInvoices     = Invoice::with('user')->latest()->take(5)->get();

        // Staff Presence Logic
        $allStaff = Staff::where('status', true)->get();
        $staffPresentToday = $allStaff->filter(function($s) {
            return $s->is_present_today && $s->is_on_shift;
        })->count();
        $totalStaff = $allStaff->count();
        
        $activeCoupons = Coupon::where('is_active', true)
                        ->where(function($q) use ($today) {
                            $q->whereNull('valid_until')->orWhere('valid_until', '>=', $today);
                        })->count();
        $activeDiscounts = DiscountRule::where('is_active', true)->count();
        
        $reconciliationDone = CashReconciliation::whereDate('created_at', $today)->exists();

        // Chart Data: Daily Sales (Last 7 Days)
        $dailySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailySales[] = [
                'label' => $date->format('D'),
                'value' => (float) Invoice::whereDate('created_at', $date)->sum('payable_amount')
            ];
        }

        // Chart Data: Weekly Sales (Last 4 Weeks)
        $weeklySales = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $weeklySales[] = [
                'label' => 'Week ' . ($i == 0 ? ' (Current)' : '-' . $i),
                'value' => (float) Invoice::whereBetween('created_at', [$start, $end])->sum('payable_amount')
            ];
        }

        // Chart Data: Monthly Sales (Current Year)
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[] = [
                'label' => Carbon::create()->month($i)->format('M'),
                'value' => (float) Invoice::whereYear('created_at', Carbon::now()->year)
                                    ->whereMonth('created_at', $i)
                                    ->sum('payable_amount')
            ];
        }

        return view('admin.index', compact(
            'totalSalesToday', 'totalAppointmentsToday', 'completedAppointmentsToday',
            'totalSalesWeek', 'totalAppointmentsWeek',
            'totalRevenue', 'totalAppointments', 'totalCustomers', 'totalUsers',
            'totalProducts', 'lowStockProducts', 'outOfStockProducts', 'inventoryValue', 'inventoryValueSell',
            'lowStockList', 'recentAppointments', 'recentInvoices', 'lateAppointments',
            'staffPresentToday', 'totalStaff', 'activeCoupons', 'activeDiscounts', 'reconciliationDone',
            'dailySales', 'weeklySales', 'monthlySales'
        ));
    }
}
