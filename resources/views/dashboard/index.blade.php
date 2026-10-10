<x-layouts.app title="Dashboard">
    <x-section>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-600">Halo, {{ auth()->user()->name }}.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary">Keluar</button>
            </form>
        </div>

        <dl class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl border border-gray-200 p-5">
                <dt class="text-sm text-gray-500">Total pesan masuk</dt>
                <dd class="mt-1 text-3xl font-bold text-gray-900">{{ $totalMessages }}</dd>
            </div>
            <div class="rounded-xl border border-gray-200 p-5">
                <dt class="text-sm text-gray-500">Belum dibaca</dt>
                <dd class="mt-1 text-3xl font-bold text-brand-700">{{ $unreadMessages }}</dd>
            </div>
        </dl>

        <h2 class="mt-10 text-xl font-semibold text-gray-900">Pesan dari formulir kontak</h2>
        <div class="mt-4 overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Pengirim</th>
                        <th class="px-4 py-3">Subjek</th>
                        <th class="px-4 py-3">Pesan</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($messages as $message)
                        <tr @class(['bg-brand-50/40' => ! $message->isRead()])>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-600">{{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $message->name }}</p>
                                <p class="text-gray-500">{{ $message->email }}@if($message->phone) · {{ $message->phone }}@endif</p>
                            </td>
                            <td class="px-4 py-3 text-gray-900">{{ $message->subject }}</td>
                            <td class="max-w-md px-4 py-3 text-gray-700">{{ \Illuminate\Support\Str::limit($message->message, 160) }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($message->isRead())
                                    <span class="rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-600">Dibaca</span>
                                @else
                                    <form method="POST" action="{{ route('dashboard.messages.read', $message) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="rounded-full bg-brand-100 px-2 py-1 text-xs font-medium text-brand-700 hover:bg-brand-500 hover:text-white">Tandai dibaca</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada pesan masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $messages->links() }}</div>
    </x-section>
</x-layouts.app>
