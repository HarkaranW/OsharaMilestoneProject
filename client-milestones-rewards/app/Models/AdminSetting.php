<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = [
        'user_id',
        'default_expiry_days',
        'reward_assignment',
        'notif_claimed',
        'notif_opened',
        'notif_expired',
        'notif_weekly',
        'enforce_one_time',
        'prevent_multi_active',
    ];

    protected $casts = [
        'notif_claimed' => 'boolean',
        'notif_opened' => 'boolean',
        'notif_expired' => 'boolean',
        'notif_weekly' => 'boolean',
        'enforce_one_time' => 'boolean',
        'prevent_multi_active' => 'boolean',
    ];
}