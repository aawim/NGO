<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
protected $fillable = [
        'title', 
        'slug', 
        'short_description', 
        'description', 
        'image', 
        'location', 
        'budget', 
        'raised_amount', 
        'status', 
        'start_date', 
        'end_date', 
        'featured'
    ];

    public function projectComments()
{
    // Fetches comments with the newest ones at the top
    return $this->hasMany(ProjectComment::class)->latest(); 
}
}
