<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'monthRevenue' => (int) Order::whereIn('status', ['confirmed', 'shipped', 'completed'])
                ->where('created_at', '>=', now()->startOfMonth())->sum('total'),
            'activeProducts' => Product::published()->count(),
            'lowStock' => Product::where('is_active', true)->where('stock', '<=', 3)->count(),
            'unreadMessages' => ContactMessage::whereNull('read_at')->count(),
            'recentOrders' => Order::latest()->take(8)->get(),
        ]);
    }
}
