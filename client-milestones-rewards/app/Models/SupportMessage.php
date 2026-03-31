<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'reward_access_id',
        'reward_token',
        'status',
        'admin_reply',
        'admin_note',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function rewardAccess()
    {
        return $this->belongsTo(RewardAccess::class);
    }
}