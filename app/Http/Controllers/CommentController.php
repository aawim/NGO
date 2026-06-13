<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\Event;
use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeProjectComment(Request $request, Project $project)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:project_comments,id'
        ]);

        $project->projectComments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('message', 'Comment posted successfully!');
    }


    public function storeCauseComment(Request $request, Cause $cause)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:cause_comments,id'
        ]);

        $cause->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('message', 'Comment posted successfully!');
    }


        public function storeEventComment(Request $request, Event $event)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:cause_comments,id'
        ]);

        $event->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('message', 'Comment posted successfully!');
    }
}
