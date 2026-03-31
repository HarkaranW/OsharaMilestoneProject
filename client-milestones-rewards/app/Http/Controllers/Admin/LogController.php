<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LogController extends Controller
{
    public function index()
    {
        $logs = RewardAccess::with(['reward', 'milestone'])
            ->latest()
            ->paginate(20);

        return view('admin.pages.logs', compact('logs'));
    }

    public function export()
    {
        $logs = RewardAccess::with(['milestone', 'reward'])->get();
        
        $filename = 'reward_logs_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Client Name',
                'Client Email',
                'Milestone',
                'Reward',
                'Status',
                'Token',
                'Opened At',
                'Claimed At',
                'Expires At',
                'Created At'
            ]);

            // CSV Data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->client_name,
                    $log->client_email,
                    $log->milestone->name ?? 'N/A',
                    $log->reward->title ?? 'N/A',
                    $this->getStatus($log),
                    $log->token,
                    $log->opened_at ?? 'N/A',
                    $log->claimed_at ?? 'N/A',
                    $log->expires_at,
                    $log->created_at
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function getStatus($log)
    {
        if ($log->claimed_at || $log->used) {
            return 'Claimed';
        } elseif ($log->opened_at) {
            return 'Opened';
        } elseif ($log->expires_at < now()) {
            return 'Expired';
        } else {
            return 'Pending';
        }
    }
}