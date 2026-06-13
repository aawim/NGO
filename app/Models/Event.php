<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
    'title', 'slug', 'description','location','event_date', 'goal_amount', 'raised_amount', 'image', 
    'status', 'featured'
    ];


    public function comments()
    {
        return $this->hasMany(EventComment::class)->latest();
    }
}
 


 