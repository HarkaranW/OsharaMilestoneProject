<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            'reward_access_id' => ['nullable', 'integer'],
            'reward_token' => ['nullable', 'string', 'max:80'],
        ]);

        SupportMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'reward_access_id' => $data['reward_access_id'] ?? null,
            'reward_token' => $data['reward_token'] ?? null,
            'status' => 'new',
            'admin_reply' => null,
            'admin_note' => null,
            'replied_at' => null,
        ]);

        return redirect()
            ->route('contact.show')
            ->with('success', 'Thanks! Your message was sent successfully.');
    }
}