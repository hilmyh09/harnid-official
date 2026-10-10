<x-layouts.admin :title="'Pesanan '.$order->order_number">
    <a href="{{ route('admin.orders.index') }}" class="btn-link">&larr; Semua pesanan</a>
    <div class="mt-3 flex flex-wrap items-center gap-3">
        <h1 class="font-display text-3xl font-medium">{{ $order->order_number }}</h1>
        <x-status-badge :status="$order->status" />
    </div>
    <p class="mt-1 text-sm text-noir-700/70">Dibuat {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</p>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="overflow-x-auto border border-ivory-200 bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-ivory-100 text-left text-xs uppercase tracking-wider text-noir-700"><tr><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Ukuran</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Qty</th><th class="px-4 py-3 text-right">Subtotal</th></tr></thead>
                    <tbody class="divide-y divide-ivory-200">
                        @foreach ($order->items as $item)
                            <tr><td class="px-4 py-3">{{ $item->product_name }}<br><span class="text-xs text-noir-700/60">{{ $item->sku }}</span></td><td class="px-4 py-3">{{ $item->size ?? '-' }}</td><td class="px-4 py-3">{{ rupiah($item->unit_price) }}</td><td class="px-4 py-3">{{ $item->quantity }}</td><td class="px-4 py-3 text-right">{{ rupiah($item->line_total) }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-ivory-200 font-medium"><tr><td colspan="4" class="px-4 py-3 text-right">Total</td><td class="px-4 py-3 text-right">{{ rupiah($order->total) }}</td></tr></tfoot>
                </table>
            </div>
            @if ($order->notes)<div class="mt-4 border border-ivory-200 bg-white p-4 text-sm"><p class="eyebrow mb-1">Catatan pelanggan</p>{{ $order->notes }}</div>@endif
        </div>

        <div class="space-y-4">
            <div class="border border-ivory-200 bg-white p-5 text-sm">
                <p class="eyebrow mb-2">Pengiriman</p>
                <p class="font-medium">{{ $order->customer_name }}</p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
                <p class="mt-2">{{ $order->customer_phone }}@if ($order->customer_email)<br>{{ $order->customer_email }}@endif</p>
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $order->customer_phone)) }}" target="_blank" rel="noopener" class="btn-link mt-3">Chat WhatsApp</a>
            </div>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="border border-ivory-200 bg-white p-5 text-sm">
                @csrf @method('PATCH')
                <label for="status" class="label">Ubah status</label>
                <select id="status" name="status" class="input">
                    @foreach (\App\Models\Order::STATUSES as $key => $label)<option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>@endforeach
                </select>
                <x-field-error for="status" />
                <button type="submit" class="btn-primary mt-3 w-full">Simpan status</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
