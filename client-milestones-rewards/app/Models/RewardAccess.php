<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardAccess extends Model
{
    protected $guarded = [];

public function reward() { return $this->belongsTo(\App\Models\Reward::class); }
public function milestone() { return $this->belongsTo(\App\Models\Milestone::class); }

}
