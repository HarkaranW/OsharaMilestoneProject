<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GeneralSettingsController extends Controller
{
    // ── GET /admin/general-settings ──────────────────────────────────────

    public function index()
    {
        $settings = GeneralSetting::instance();
        return view('admin.pages.general-settings', compact('settings'));
    }

    // ── POST /admin/general-settings ─────────────────────────────────────

    public function update(Request $request)
    {
        $section  = $request->input('section');
        $settings = GeneralSetting::instance();

        match ($section) {
            'branding' => $this->saveBranding($request, $settings),
            'email'    => $this->saveEmail($request, $settings),
            'rewards'  => $this->saveRewards($request, $settings),
            'security' => $this->saveSecurity($request, $settings),
            default    => null,
        };

        return back()
            ->with('success', 'Settings saved.')
            ->with('saved_section', $section);
    }

    // ── POST /admin/general-settings/test-email ──────────────────────────

    public function testEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            Mail::raw('This is a test email from your Bizlyt admin panel.', function ($msg) use ($request) {
                $msg->to($request->email)->subject('Test Email — Bizlyt');
            });
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ── Section savers ────────────────────────────────────────────────────

    protected function saveBranding(Request $request, GeneralSetting $settings): void
    {
        $request->validate([
            'app_name'      => 'nullable|string|max:100',
            'support_email' => 'nullable|email|max:255',
            'accent_color'  => 'nullable|string|max:20',
            'logo_light'    => 'nullable|image|max:2048',
            'logo_dark'     => 'nullable|image|max:2048',
            'favicon'       => 'nullable|file|max:512',
        ]);

        $data = [
            'app_name'      => $request->input('app_name') ?: 'Bizlyt',
            'support_email' => $request->input('support_email'),
            'accent_color'  => $request->input('accent_color') ?: '#3b82f6',
        ];

        if ($request->hasFile('logo_light')) {
            $data['logo_light'] = $request->file('logo_light')->store('brand', 'public');
        }
        if ($request->hasFile('logo_dark')) {
            $data['logo_dark'] = $request->file('logo_dark')->store('brand', 'public');
        }
        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('brand', 'public');
        }

        $settings->update($data);
    }

    protected function saveEmail(Request $request, GeneralSetting $settings): void
    {
        $request->validate([
            'mail_driver'       => 'nullable|string',
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|integer',
            'mail_encryption'   => 'nullable|string|max:10',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_from_name'    => 'nullable|string|max:100',
            'mail_from_address' => 'nullable|email|max:255',
        ]);

        $settings->update([
            'mail_driver'       => $request->input('mail_driver'),
            'mail_host'         => $request->input('mail_host'),
            'mail_port'         => $request->input('mail_port'),
            'mail_encryption'   => $request->input('mail_encryption'),
            'mail_username'     => $request->input('mail_username'),
            'mail_password'     => $request->input('mail_password'),
            'mail_from_name'    => $request->input('mail_from_name'),
            'mail_from_address' => $request->input('mail_from_address'),
        ]);
    }

    protected function saveRewards(Request $request, GeneralSetting $settings): void
    {
        $request->validate([
            'default_expiry'       => 'nullable|integer',
            'reward_assignment'    => 'nullable|string',
            'max_active_links'     => 'nullable|integer|min:1',
            'points_per_milestone' => 'nullable|integer|min:1',
        ]);

        $settings->update([
            'default_expiry'       => $request->input('default_expiry', 7),
            'reward_assignment'    => $request->input('reward_assignment', 'random'),
            'max_active_links'     => $request->input('max_active_links', 1),
            'points_per_milestone' => $request->input('points_per_milestone', 100),
            'notify_claimed'       => $request->boolean('notify_claimed'),
            'notify_opened'        => $request->boolean('notify_opened'),
            'notify_expired'       => $request->boolean('notify_expired'),
            'notify_weekly'        => $request->boolean('notify_weekly'),
        ]);
    }

    protected function saveSecurity(Request $request, GeneralSetting $settings): void
    {
        $request->validate([
            'max_login_attempts'      => 'nullable|integer|min:3|max:20',
            'session_timeout_minutes' => 'nullable|integer|min:5',
            'allowed_ips'             => 'nullable|string',
        ]);

        $settings->update([
            'enforce_one_time'        => $request->boolean('enforce_one_time'),
            'prevent_multiple_links'  => $request->boolean('prevent_multiple_links'),
            'require_email_verify'    => $request->boolean('require_email_verify'),
            'require_2fa'             => $request->boolean('require_2fa'),
            'session_timeout_enabled' => $request->boolean('session_timeout_enabled'),
            'session_timeout_minutes' => $request->input('session_timeout_minutes', 30),
            'max_login_attempts'      => $request->input('max_login_attempts', 5),
            'allowed_ips'             => $request->input('allowed_ips'),
        ]);
    }
}