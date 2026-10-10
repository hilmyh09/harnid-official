<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class OrderService
{
    public function __construct(private readonly Cart $cart) {}

    /**
     * Membuat pesanan dari isi keranjang secara atomik dan mengurangi stok.
     *
     * @param  array<string, mixed>  $customer
     */
    public function placeOrder(array $customer): Order
    {
        $lines = $this->cart->lines();

        if ($lines->isEmpty()) {
            throw new RuntimeException('Keranjang kosong.');
        }

        $order = DB::transaction(function () use ($lines, $customer) {
            $subtotal = 0;
            $items = [];

            foreach ($lines as $line) {
                /** @var Product $product */
                $product = Product::query()->lockForUpdate()->findOrFail($line['product']->id);

                if (! $product->isPublished() || $product->stock < $line['quantity']) {
                    throw new RuntimeException("Stok {$product->name} tidak mencukupi.");
                }

                $product->decrement('stock', $line['quantity']);

                $lineTotal = $product->price * $line['quantity'];
                $subtotal += $lineTotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'size' => $line['size'],
                    'unit_price' => $product->price,
                    'quantity' => $line['quantity'],
                    'line_total' => $lineTotal,
                ];
            }

            $order = Order::create([
                'order_number' => $this->generateNumber(),
                'customer_name' => $customer['customer_name'],
                'customer_phone' => $customer['customer_phone'],
                'customer_email' => $customer['customer_email'] ?? null,
                'address' => $customer['address'],
                'city' => $customer['city'],
                'province' => $customer['province'],
                'postal_code' => $customer['postal_code'] ?? null,
                'notes' => $customer['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total' => $subtotal,
                'status' => 'pending',
            ]);

            $order->items()->createMany($items);

            return $order;
        });

        $this->cart->clear();

        return $order->load('items');
    }

    private function generateNumber(): string
    {
        do {
            $number = 'HRN-'.now()->format('ymd').'-'.strtoupper(Str::random(4));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    /** Teks ringkasan pesanan untuk dikirim lewat WhatsApp. */
    public function whatsappMessage(Order $order): string
    {
        $lines = ['Halo '.config('company.name').", saya ingin konfirmasi pesanan *{$order->order_number}*:", ''];

        foreach ($order->items as $item) {
            $size = $item->size ? " ({$item->size})" : '';
            $lines[] = "- {$item->product_name}{$size} x{$item->quantity} = Rp ".number_format($item->line_total, 0, ',', '.');
        }

        $lines[] = '';
        $lines[] = 'Total: Rp '.number_format($order->total, 0, ',', '.');
        $lines[] = "Nama: {$order->customer_name}";
        $lines[] = "Alamat: {$order->address}, {$order->city}, {$order->province}";

        return implode("\n", $lines);
    }
}
