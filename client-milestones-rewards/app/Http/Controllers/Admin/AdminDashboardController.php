<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardAccess;
use App\Models\Milestone;
use App\Models\Reward;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalLinks = RewardAccess::count();
        $claimedLinks = RewardAccess::where('used', true)->count();
        $openedLinks = RewardAccess::whereNotNull('opened_at')->count();
        $expiredLinks = RewardAccess::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->count();

        $openRate = $totalLinks > 0 ? round(($openedLinks / $totalLinks) * 100) : null;

        $recent = RewardAccess::with(['reward', 'milestone'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.pages.dashboard', compact(
            'totalLinks',
            'claimedLinks',
            'openedLinks',
            'expiredLinks',
            'openRate',
            'recent'
        ));
    }
}