<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsStory extends Model
{
    use SoftDeletes;

    protected $guarded = ['id']; // Allow mass assignment for all fields except ID

    protected $casts = [
        'categories'   => 'array',
        'tags'         => 'array',
        'event_date'   => 'date',
        'published_at' => 'datetime',
        'featured'     => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
