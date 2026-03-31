<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardLinkMail;

use App\Models\Reward;
use App\Models\Milestone;
use App\Models\RewardAccess;

class TriggerController extends Controller
{
    public function create()
    {
        $clients = RewardAccess::query()
            ->select('client_email', 'client_name')
            ->whereNotNull('client_email')
            ->where('client_email', '!=', '')
            ->distinct()
            ->orderBy('client_name')
            ->get();

        $milestones = Milestone::query()
            ->orderBy('name')
            ->get();

        return view('admin.pages.trigger', compact('clients', 'milestones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_email' => ['nullable', 'email'],
            'client_name'  => ['nullable', 'string', 'max:255'],

            'new_client_email' => ['nullable', 'email'],
            'new_client_name'  => ['nullable', 'string', 'max:255'],

            'milestone_id' => ['required', 'integer', 'exists:milestones,id'],
        ]);

        $milestone = Milestone::findOrFail($data['milestone_id']);

        $email = ($data['new_client_email'] ?? null) ?: ($data['client_email'] ?? null);
        $name  = ($data['new_client_name'] ?? null)  ?: ($data['client_name'] ?? null);

        if (!$email) {
            return back()
                ->withErrors(['client_email' => 'Select a client OR enter a new client email.'])
                ->withInput();
        }

        if (!$name) {
            $name = RewardAccess::where('client_email', $email)
                ->orderByDesc('id')
                ->value('client_name') ?: 'Client';
        }

        // If already claimed for this milestone → block
        $alreadyClaimed = RewardAccess::where('client_email', $email)
            ->where('milestone_id', $milestone->id)
            ->where('used', true)
            ->exists();

        if ($alreadyClaimed) {
            return back()
                ->withErrors(['milestone_id' => 'This client already claimed a reward for this milestone.'])
                ->withInput();
        }

        // If there’s an active unused link → block
        $hasActiveUnused = RewardAccess::where('client_email', $email)
            ->where('milestone_id', $milestone->id)
            ->where('used', false)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->exists();

        if ($hasActiveUnused) {
            return back()
                ->withErrors(['milestone_id' => 'This client already has an active unused link for this milestone.'])
                ->withInput();
        }

        // Random reward
        $rewardId = Reward::inRandomOrder()->value('id');

        if (!$rewardId) {
            return back()
                ->withErrors(['milestone_id' => 'No rewards exist yet. Create rewards first.'])
                ->withInput();
        }

        // UNIQUE constraint (client_email, milestone_id) → reissue by updating existing row
        $existing = RewardAccess::where('client_email', $email)
            ->where('milestone_id', $milestone->id)
            ->first();

        if ($existing) {
            $existing->update([
                'client_name' => $name,
                'reward_id'   => $rewardId,
                'token'       => Str::random(40),
                'expires_at'  => now()->addDays(7),
                'used'        => false,
                'opened_at'   => null,
                'claimed_at'  => null,
            ]);

            $access = $existing;
        } else {
            $access = RewardAccess::create([
                'client_name'  => $name,
                'client_email' => $email,
                'milestone_id' => $milestone->id,
                'reward_id'    => $rewardId,
                'token'        => Str::random(40),
                'expires_at'   => now()->addDays(7),
                'used'         => false,
                'opened_at'    => null,
                'claimed_at'   => null,
            ]);
        }

        $link = url('/reward/' . $access->token);

        try {
            Mail::to($access->client_email)->send(new RewardLinkMail($access, $link));

            return redirect('/admin/manual-trigger')
                ->with('success', "Link generated + email sent to {$email}")
                ->with('link', $link)
                ->with('token', $access->token);
        } catch (\Throwable $e) {
            return redirect('/admin/manual-trigger')
                ->with('success', "Link generated for {$email} (email failed to send)")
                ->with('link', $link)
                ->with('token', $access->token)
                ->with('mail_error', $e->getMessage());
        }
    }
}