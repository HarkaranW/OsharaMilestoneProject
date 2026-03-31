<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Create defaults if user has no row yet
        $settings = AdminSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'default_expiry_days' => 7,
                'reward_assignment' => 'random',
                'notif_claimed' => true,
                'notif_opened' => true,
                'notif_expired' => false,
                'notif_weekly' => true,
                'enforce_one_time' => true,
                'prevent_multi_active' => true,
            ]
        );

        return view('admin.pages.settings', compact('user', 'settings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'default_expiry_days' => ['required', 'integer', 'min:1', 'max:365'],
            'reward_assignment' => ['required', 'in:random,milestone'],

            // switches (checkboxes) are optional -> we’ll normalize to booleans
            'notif_claimed' => ['nullable'],
            'notif_opened' => ['nullable'],
            'notif_expired' => ['nullable'],
            'notif_weekly' => ['nullable'],

            'enforce_one_time' => ['nullable'],
            'prevent_multi_active' => ['nullable'],
        ]);

        $settings = AdminSetting::firstOrCreate(['user_id' => $user->id]);

        $settings->update([
            'default_expiry_days' => (int)$data['default_expiry_days'],
            'reward_assignment' => $data['reward_assignment'],

            'notif_claimed' => $request->boolean('notif_claimed'),
            'notif_opened' => $request->boolean('notif_opened'),
            'notif_expired' => $request->boolean('notif_expired'),
            'notif_weekly' => $request->boolean('notif_weekly'),

            'enforce_one_time' => $request->boolean('enforce_one_time'),
            'prevent_multi_active' => $request->boolean('prevent_multi_active'),
        ]);

        return back()->with('success', 'Settings saved.');
    }
}