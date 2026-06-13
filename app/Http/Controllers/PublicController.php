<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeVolunteer;
use App\Models\Cause;
use App\Models\Contact;
use App\Models\Event;
use App\Models\NewsStory;
use App\Models\Project;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PublicController extends Controller
{
  public function home()
    {
        // 1. Calculate Real Stats
        $totalRaised = Project::sum('raised_amount') + Cause::sum('raised_amount') + Event::sum('raised_amount');
        $activeProjects = Project::count(); 
        $totalVolunteers = Volunteer::count();

        // 2. Get Featured Causes (Latest 3 active)
        $featuredCauses = Cause::where('status', 'active')->get();

        // 3. Get Upcoming Events (Next 3 events happening from today onwards)
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        // 4. Get Latest News (Latest 3 published)
        $latestNews = NewsStory::where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('Welcome', [ 
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            
            // Pass all real data to Vue
            'stats' => [
                'total_raised' => $totalRaised,
                'active_projects' => $activeProjects,
                'total_volunteers' => $totalVolunteers,
            ],
            'featuredCauses' => $featuredCauses,
            'upcomingEvents' => $upcomingEvents,
            'latestNews'     => $latestNews,
        ]);
    }

    
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


    public function contact()
    {
        return Inertia::render('Public/Contact');
    }

    public function submitContact(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'request_type' => 'required|string',
            'message'      => 'required|string|max:2000',
            // Simple honeypot/checkbox validation to stop basic bots
            'bot_check'    => 'accepted' 
        ]);

        // 2. Save the message to the database
        Contact::create([
            'user_id'      => auth()->id(), // Will be null if guest
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'request_type' => $validated['request_type'],
            'message'      => $validated['message'],
        ]);

        // 3. Return a success message
        return back()->with('message', 'Thank you for reaching out! Your message has been sent successfully.');
    }

    public function volunteer()
    {
        return Inertia::render('Public/Volunteer');
    }

  public function submitVolunteer(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            // Ensure they haven't already applied
            'email'        => 'required|email|max:255|unique:volunteers,email',
            'phone'        => 'nullable|string|max:50',
            'availability' => 'required|string',
            'skills'       => 'nullable|array',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $userId = auth()->id();

        // If the user is NOT logged in
        if (!$userId) {
            // Check if an account already exists with this email
            $user = User::where('email', $validated['email'])->first();

            // If no account exists, create one!
            if (!$user) {
                $tempPassword = Str::random(10); // Generate a random 10-character password

                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($tempPassword),
                    'role'     => 'volunteer', // Set the role immediately
                ]);

                // Send the welcome email with their new password
                Mail::to($user->email)->send(new WelcomeVolunteer($user, $tempPassword));
            } 
            // Optional: If they already had a standard account, upgrade them to a volunteer role
            elseif ($user->role === 'user' || $user->role === null) {
                $user->update(['role' => 'volunteer']);
            }

            // Grab the ID of the new (or existing) user
            $userId = $user->id;
        }

        // Attach the confirmed user ID and default status to the application
        $validated['user_id'] = $userId;
        $validated['status'] = 'pending';

        // Handle the profile image upload if they provided one
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('volunteers', 'public');
        }

        // Finally, save the volunteer application to the database
        Volunteer::create($validated);

        return back()->with('message', 'Thank you for applying! An account has been created for you. Please check your email for login details.');
    }
}