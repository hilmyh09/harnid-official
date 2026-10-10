<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data DEMO untuk lingkungan lokal/staging. Jangan dijalankan di produksi.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command?->error('DemoSeeder tidak boleh dijalankan di produksi.');

            return;
        }

        $this->call(CatalogSeeder::class);

        User::query()->updateOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Admin DEMO', 'password' => 'password'],
        );

        ContactMessage::factory()->count(3)->create(['subject' => '[DEMO] Tanya ketersediaan ukuran']);

        if (Order::count() === 0) {
            $products = Product::published()->take(3)->get();

            foreach (['pending', 'confirmed', 'completed'] as $status) {
                $order = Order::factory()->create(['status' => $status, 'customer_name' => '[DEMO] Pelanggan']);
                $subtotal = 0;

                foreach ($products as $product) {
                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku' => $product->sku,
                        'size' => $product->sizes[0] ?? null,
                        'unit_price' => $product->price,
                        'quantity' => 1,
                        'line_total' => $product->price,
                    ]);
                    $subtotal += $product->price;
                }

                $order->update(['subtotal' => $subtotal, 'total' => $subtotal]);
            }
        }
    }
}
