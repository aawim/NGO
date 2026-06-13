<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    protected $fillable = [
    'title', 'slug', 'description', 'goal_amount', 'raised_amount', 'image', 
    'status', 'featured'
    ];

    public function comments()
    {
        return $this->hasMany(CauseComment::class)->latest();
    }
}
