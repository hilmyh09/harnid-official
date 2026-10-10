<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $orders = Order::withCount('items')
            ->when($status && isset(Order::STATUSES[$status]), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', ['orders' => $orders, 'status' => $status]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load('items')]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(array_keys(Order::STATUSES))]]);

        $order->update(['status' => $data['status']]);

        return back()->with('status', 'Status pesanan diperbarui menjadi '.$order->statusLabel().'.');
    }
}
