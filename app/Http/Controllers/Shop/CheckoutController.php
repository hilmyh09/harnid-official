<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\Cart;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function __construct(private readonly Cart $cart, private readonly OrderService $orders) {}

    public function show(): View|RedirectResponse
    {
        $lines = $this->cart->lines();

        if ($lines->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang masih kosong.');
        }

        return view('shop.checkout', ['lines' => $lines, 'subtotal' => $this->cart->subtotal()]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->orders->placeOrder($request->validated());
        } catch (RuntimeException $e) {
            return redirect()->route('cart.index')->withErrors(['cart' => $e->getMessage()]);
        }

        session(['last_order_number' => $order->order_number]);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        abort_unless(session('last_order_number') === $order->order_number, 404);

        $order->load('items');

        return view('shop.order-success', [
            'order' => $order,
            'whatsappUrl' => 'https://wa.me/'.config('company.whatsapp').'?text='.rawurlencode($this->orders->whatsappMessage($order)),
        ]);
    }
}
