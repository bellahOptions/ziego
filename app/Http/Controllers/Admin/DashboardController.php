<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'total_revenue'    => Order::where('payment_status', 'paid')->sum('total'),
            'total_products'   => Product::count(),
            'low_stock'        => Product::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'out_of_stock'     => Product::where('stock', 0)->count(),
            'total_customers'  => User::where('role', 'customer')->count(),
            'total_employees'  => Employee::where('status', 'active')->count(),
        ];

        $recentOrders = Order::with('user', 'items')
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        $rangeStart = Carbon::now()->startOfMonth()->subMonths(5);
        $monthlyOrders = Order::where('created_at', '>=', $rangeStart)
            ->get(['created_at', 'total', 'payment_status']);

        $chartLabels = [];
        $chartRevenue = [];
        $chartOrders = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');

            $ordersInMonth = $monthlyOrders->filter(
                fn ($order) => $order->created_at->isSameMonth($month) && $order->created_at->isSameYear($month)
            );

            $chartRevenue[] = (float) $ordersInMonth->where('payment_status', 'paid')->sum('total');
            $chartOrders[] = $ordersInMonth->count();
        }

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'topProducts', 'chartLabels', 'chartRevenue', 'chartOrders'
        ));
    }
}
