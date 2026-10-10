<x-layouts.shop title="Pesanan dibuat">
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <p class="eyebrow">Terima kasih</p>
        <h1 class="mt-2 font-display text-4xl font-medium">Pesanan {{ $order->order_number }} berhasil dibuat</h1>
        <p class="mt-3 text-sm text-noir-700">Stok sudah kami amankan. Lanjutkan konfirmasi pembayaran dan ongkir melalui WhatsApp agar pesanan segera diproses.</p>

        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-primary mt-8 w-full sm:w-auto">Konfirmasi via WhatsApp</a>

        <div class="mt-10 border border-ivory-200 bg-white p-6 text-sm">
            <p class="eyebrow">Rincian</p>
            <ul class="mt-4 divide-y divide-ivory-200">
                @foreach ($order->items as $item)
                    <li class="flex justify-between gap-4 py-3">
                        <span>{{ $item->product_name }}@if ($item->size) ({{ $item->size }})@endif &times;{{ $item->quantity }}</span>
                        <span>{{ rupiah($item->line_total) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 flex justify-between border-t border-ivory-200 pt-4 text-base font-medium"><span>Total</span><span>{{ rupiah($order->total) }}</span></div>
            <p class="mt-6 text-xs text-noir-700/70">Dikirim ke: {{ $order->customer_name }}, {{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
        </div>

        <a href="{{ route('catalog.index') }}" class="btn-link mt-8">Kembali belanja</a>
    </section>
</x-layouts.shop>
