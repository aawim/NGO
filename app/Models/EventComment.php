<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    protected $fillable = ['user_id', 'event_id', 'parent_id', 'body'];

  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(EventComment::class, 'parent_id')->latest();
    }
}
