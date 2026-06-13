<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    protected $fillable = ['user_id', 'project_id','parent_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function replies()
    {
        return $this->hasMany(ProjectComment::class, 'parent_id')->latest();
    }
}
