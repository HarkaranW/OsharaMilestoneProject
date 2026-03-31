<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportMessageController extends Controller
{
    public function index()
    {
        $messages = SupportMessage::query()
            ->latest()
            ->paginate(20);

        return view('admin.pages.support-message', compact('messages'));
    }

    public function show(SupportMessage $supportMessage)
    {
        return view('admin.pages.support-message-show', compact('supportMessage'));
    }

    public function update(Request $request, SupportMessage $supportMessage)
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,open,replied,closed'],
            'admin_note' => ['nullable', 'string', 'max:3000'],
            'admin_reply' => ['nullable', 'string', 'max:5000'],
            'send_reply' => ['nullable'],
        ]);

        $supportMessage->status = $data['status'];
        $supportMessage->admin_note = $data['admin_note'] ?? null;
        $supportMessage->admin_reply = $data['admin_reply'] ?? null;

        if ($request->boolean('send_reply') && !empty($data['admin_reply'])) {
            Mail::send('emails.support-reply', [
                'messageModel' => $supportMessage,
                'replyText' => $data['admin_reply'],
            ], function ($message) use ($supportMessage) {
                $message->to($supportMessage->email)
                    ->subject('Reply to your support request - Oshara');
            });

            $supportMessage->status = 'replied';
            $supportMessage->replied_at = now();
        }

        $supportMessage->save();

        return back()->with('success', 'Support message updated successfully.');
    }
}