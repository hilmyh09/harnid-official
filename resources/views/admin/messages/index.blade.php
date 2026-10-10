<x-layouts.admin title="Pesan masuk">
    <h1 class="font-display text-3xl font-medium">Pesan masuk <span class="ml-2 align-middle text-sm font-sans text-noir-700/70">{{ $unread }} belum dibaca</span></h1>
    <div class="mt-6 overflow-x-auto border border-ivory-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-ivory-100 text-left text-xs uppercase tracking-wider text-noir-700"><tr><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Pengirim</th><th class="px-4 py-3">Subjek</th><th class="px-4 py-3">Pesan</th><th class="px-4 py-3">Status</th></tr></thead>
            <tbody class="divide-y divide-ivory-200">
                @forelse ($messages as $message)
                    <tr @class(['bg-ivory-50' => ! $message->isRead()])>
                        <td class="whitespace-nowrap px-4 py-3 text-noir-700/70">{{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3"><p class="font-medium">{{ $message->name }}</p><p class="text-xs text-noir-700/60">{{ $message->email }}@if ($message->phone) · {{ $message->phone }}@endif</p></td>
                        <td class="px-4 py-3">{{ $message->subject }}</td>
                        <td class="max-w-md px-4 py-3">{{ \Illuminate\Support\Str::limit($message->message, 160) }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            @if ($message->isRead())<span class="badge bg-gray-200 text-gray-700">Dibaca</span>
                            @else<form method="POST" action="{{ route('admin.messages.read', $message) }}">@csrf @method('PATCH')<button type="submit" class="badge bg-noir-900 text-ivory-50 hover:bg-gold-600">Tandai dibaca</button></form>@endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-noir-700/70">Belum ada pesan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $messages->links() }}</div>
</x-layouts.admin>
