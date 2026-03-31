<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = [];
    protected $fillable = ['title', 'description', 'instructions', 'one_time'];

}
