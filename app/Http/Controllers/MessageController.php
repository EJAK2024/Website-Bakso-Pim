<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        $unreadCount = Message::where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(Message $message)
    {
        $message->update(['is_read' => true]);

        return view('admin.messages.show', compact('message'));
    }

    public function markAllRead()
    {
        Message::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create($validated);

        return redirect('/#contact')->with('success', 'Pesan berhasil dikirim! Terima kasih telah menghubungi kami.');
    }
}
