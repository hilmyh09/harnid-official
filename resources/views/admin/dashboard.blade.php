<x-layouts.admin title="Dashboard">
    <h1 class="font-display text-3xl font-medium">Dashboard</h1>
    <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="border border-ivory-200 bg-white p-5"><dt class="text-xs uppercase tracking-wider text-noir-700/70">Pesanan menunggu</dt><dd class="mt-1 text-3xl font-semibold">{{ $pendingOrders }}</dd></div>
        <div class="border border-ivory-200 bg-white p-5"><dt class="text-xs uppercase tracking-wider text-noir-700/70">Omzet bulan ini</dt><dd class="mt-1 text-2xl font-semibold">{{ rupiah($monthRevenue) }}</dd><dd class="text-xs text-noir-700/60">pesanan terkonfirmasi/dikirim/selesai</dd></div>
        <div class="border border-ivory-200 bg-white p-5"><dt class="text-xs uppercase tracking-wider text-noir-700/70">Produk tayang</dt><dd class="mt-1 text-3xl font-semibold">{{ $activeProducts }}</dd></div>
        <div class="border border-ivory-200 bg-white p-5"><dt class="text-xs uppercase tracking-wider text-noir-700/70">Stok menipis (≤3)</dt><dd class="mt-1 text-3xl font-semibold {{ $lowStock ? 'text-red-700' : '' }}">{{ $lowStock }}</dd></div>
        <div class="border border-ivory-200 bg-white p-5"><dt class="text-xs uppercase tracking-wider text-noir-700/70">Pesan belum dibaca</dt><dd class="mt-1 text-3xl font-semibold">{{ $unreadMessages }}</dd></div>
    </dl>

    <div class="mt-10 flex items-center justify-between">
        <h2 class="font-display text-2xl font-medium">Pesanan terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn-link">Semua pesanan</a>
    </div>
    <div class="mt-4 overflow-x-auto border border-ivory-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-ivory-100 text-left text-xs uppercase tracking-wider text-noir-700"><tr><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Pelanggan</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Waktu</th></tr></thead>
            <tbody class="divide-y divide-ivory-200">
                @forelse ($recentOrders as $order)
                    <tr>
                        <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-medium hover:underline">{{ $order->order_number }}</a></td>
                        <td class="px-4 py-3">{{ $order->customer_name }}<br><span class="text-xs text-noir-700/60">{{ $order->customer_phone }}</span></td>
                        <td class="px-4 py-3">{{ rupiah($order->total) }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$order->status" /></td>
                        <td class="px-4 py-3 text-noir-700/70">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-noir-700/70">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
