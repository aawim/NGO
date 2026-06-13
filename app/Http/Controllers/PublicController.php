<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\Event;
use App\Models\NewsStory;
use App\Models\Project;
use Inertia\Inertia;

class PublicController extends Controller
{
    /**
     * Display the list of public projects.
     */
    public function projects()
    {
        // Fetch projects, but exclude 'draft' or 'planned' statuses for the public.
        // Orders featured projects first, then by the newest.
        $projects = Project::whereIn('status', ['Active', 'Completed'])
            ->orderBy('featured', 'desc')
            ->latest()
            ->get();

        return Inertia::render('Public/Projects/Index', [
            'projects' => $projects
        ]);
    }

    /**
     * Display a single project's detail page.
     */
    public function showProject($slug)
    {
       
        // Find the project by its slug, or return a 404 error if it doesn't exist
        $project = Project::with(['projectComments' => function ($query) {
            // Only fetch top-level comments
            $query->whereNull('parent_id')
                  // Eager load the user, the replies, and the user of the replies
                  ->with(['user', 'replies.user'])
                  ->latest();
        }])
        ->where('slug', $slug)
        ->whereIn('status', ['Active', 'Completed'])
        ->firstOrFail();

        return Inertia::render('Public/Projects/ProjectDetail', [
            'project' => $project
        ]);
    }

    public function causes()
    {
        // Fetch active/completed causes
        $causes = Cause::whereIn('status', ['active', 'completed'])
            ->orderBy('featured', 'desc')
            ->latest()
            ->get();

        return Inertia::render('Public/Causes/Index', [
            'causes' => $causes
        ]);
    }

    public function showCause($slug)
    {
        $cause = Cause::with(['comments' => function ($query) {
            $query->whereNull('parent_id')
                  ->with(['user', 'replies.user'])
                  ->latest();
        }])
        ->where('slug', $slug)
        ->whereIn('status', ['active', 'completed'])
        ->firstOrFail();

        return Inertia::render('Public/Causes/CauseDetail', [
            'cause' => $cause
        ]);
    }

    public function events()
    {
        // Order by upcoming events first
        $events = Event::orderBy('event_date', 'asc')->get();

        return Inertia::render('Public/Events/Index', [
            'events' => $events
        ]);
    }

    public function showEvent(Event $event)
    {
        // We can use route model binding (Event $event) since we pass the ID in the URL
        $event->load(['comments' => function ($query) {
            $query->whereNull('parent_id')
                  ->with(['user', 'replies.user'])
                  ->latest();
        }]);

        return Inertia::render('Public/Events/EventDetail', [
            'event' => $event
        ]);
    }


    public function news()
    {
        // Get all published stories, order by pinned/featured first, then newest
        $stories = NewsStory::where('status', 'published')
            ->orderBy('featured', 'desc')
            ->latest('published_at')
            ->get();

        return Inertia::render('Public/NewsStories/News', [
            'stories' => $stories
        ]);
    }

    public function showNews($slug)
    {
        $story = NewsStory::with('user')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view counter quietly so it doesn't update the updated_at timestamp
        $story->increment('views');

        return Inertia::render('Public/NewsStories/NewsDetail', [
            'story' => $story
        ]);
    }
}