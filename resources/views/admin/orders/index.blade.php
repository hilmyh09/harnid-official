<x-layouts.admin title="Pesanan">
    <h1 class="font-display text-3xl font-medium">Pesanan</h1>
    <div class="mt-6 flex flex-wrap gap-2 text-xs">
        <a href="{{ route('admin.orders.index') }}" class="badge {{ ! $status ? 'bg-noir-900 text-ivory-50' : 'bg-white border border-ivory-200' }}">Semua</a>
        @foreach (\App\Models\Order::STATUSES as $key => $label)
            <a href="{{ route('admin.orders.index', ['status' => $key]) }}" class="badge {{ $status === $key ? 'bg-noir-900 text-ivory-50' : 'bg-white border border-ivory-200' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="mt-4 overflow-x-auto border border-ivory-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-ivory-100 text-left text-xs uppercase tracking-wider text-noir-700"><tr><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Pelanggan</th><th class="px-4 py-3">Item</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Waktu</th></tr></thead>
            <tbody class="divide-y divide-ivory-200">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-medium hover:underline">{{ $order->order_number }}</a></td>
                        <td class="px-4 py-3">{{ $order->customer_name }}<br><span class="text-xs text-noir-700/60">{{ $order->customer_phone }} · {{ $order->city }}</span></td>
                        <td class="px-4 py-3">{{ $order->items_count }}</td>
                        <td class="px-4 py-3">{{ rupiah($order->total) }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$order->status" /></td>
                        <td class="px-4 py-3 text-noir-700/70">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-noir-700/70">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</x-layouts.admin>
