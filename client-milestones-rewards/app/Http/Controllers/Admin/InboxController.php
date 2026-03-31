<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        // Simple demo inbox items (later you can connect real DB messages)
        $messages = [
            ['from' => 'System', 'subject' => 'Welcome to Admin', 'time' => now()->subMinutes(10)->toDateTimeString()],
            ['from' => 'Client Rewards', 'subject' => 'A reward link was generated', 'time' => now()->subHours(2)->toDateTimeString()],
            ['from' => 'Logs', 'subject' => 'New reward opened', 'time' => now()->subDay()->toDateTimeString()],
        ];

        $user = Auth::user();
        return view('admin.pages.inbox', compact('messages', 'user'));
    }
}