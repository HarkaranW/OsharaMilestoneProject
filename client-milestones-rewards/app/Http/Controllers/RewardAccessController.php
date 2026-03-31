<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardAccess;

class RewardAccessController extends Controller
{
    public function show(Request $request, $token)
    {
        $access = RewardAccess::where('token', $token)->first();

        if (!$access) {
            return view('reward.expired');
        }

        if ($access->used_at) {
            return view('reward.used');
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return view('reward.expired');
        }

        return view('reward.valid', [
            'milestone' => $access->milestone,
            'reward' => $access->reward,
            'access' => $access
        ]);
    }
}
