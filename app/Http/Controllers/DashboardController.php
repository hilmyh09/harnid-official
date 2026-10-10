<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'totalMessages' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::whereNull('read_at')->count(),
            'messages' => ContactMessage::latest()->paginate(10),
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
