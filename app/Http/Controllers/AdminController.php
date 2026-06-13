<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Volunteer;
use App\Models\User;
use App\Models\NewsStory;

class AdminController extends Controller
{
  public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        // 1. Projects
        $totalProjects = Project::count();
        $newProjectsThisMonth = Project::where('created_at', '>=', $startOfMonth)->count();

        // 2. Causes
        $activeCauses = Cause::where('status', 'active')->count();

        // 3. Donations (Summing 'raised_amount' across models)
        $totalRaised = Project::sum('raised_amount') 
                     + Cause::sum('raised_amount') 
                     + Event::sum('raised_amount');

        // 4. People
        $totalVolunteers = Volunteer::count();
        $pendingVolunteers = Volunteer::where('status', 'pending')->count();
        $totalUsers = User::count();

        // 5. Events
        $upcomingEvents = Event::where('event_date', '>=', $now)->count();

        // 6. News
        $publishedNews = NewsStory::where('status', 'published')->count();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'projects' => [
                    'total' => $totalProjects,
                    'new_this_month' => $newProjectsThisMonth,
                ],
                'causes' => [
                    'active' => $activeCauses,
                ],
                'donations' => [
                    'total_raised' => $totalRaised,
                ],
                'people' => [
                    'total_volunteers' => $totalVolunteers,
                    'pending_volunteers' => $pendingVolunteers,
                    'total_users' => $totalUsers,
                ],
                'events' => [
                    'upcoming' => $upcomingEvents,
                ],
                'news' => [
                    'published' => $publishedNews,
                ]
            ]
        ]);
    }
}
