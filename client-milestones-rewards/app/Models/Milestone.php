<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'name',
        'type',
        'trigger_condition',
        'reward_id',
    ];

    public function reward()
    {
        return $this->belongsTo(\App\Models\Reward::class);
    }

}
