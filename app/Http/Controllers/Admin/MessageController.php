<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(15),
            'unread' => ContactMessage::whereNull('read_at')->count(),
        ]);
    }

    public function markRead(ContactMessage $message): RedirectResponse
    {
        if (! $message->isRead()) {
            $message->forceFill(['read_at' => now()])->save();
        }

        return back()->with('status', 'Pesan ditandai sudah dibaca.');
    }
}
