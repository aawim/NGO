<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // Fetch all projects, ordered by newest first
        $events = Event::latest()->get(); 
     
        // Pass the data to the Vue component
        return Inertia::render('Admin/Event/Event', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
    {
       $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'location' => ['nullable', 'string', 'max:255'],
        'event_date' => ['nullable', 'date'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'goal_amount' => ['nullable', 'numeric'],
        'raised_amount' => ['nullable', 'numeric'],
        'status' => ['required', 'string'],
        'featured' => ['nullable', 'boolean'],
    ]);

        // Generate slug automatically
    $validated['slug'] = Str::slug($validated['title']);

    // Make slug unique
    $originalSlug = $validated['slug'];
    $count = 1;

    while (Event::where('slug', $validated['slug'])->exists()) {
        $validated['slug'] = $originalSlug . '-' . $count++;
    }

    if ($request->hasFile('image')) {

    $path =  $validated['image'] = $request->file('image')
            ->store('events', 'public');
            $validated['image'] = $path;
    }
    $validated['image'] = $path;
    $validated['featured'] = $request->boolean('featured');

    Event::create($validated);
        // Inertia automatically redirects back to the index page with fresh data
        return redirect()->back()->with('message', 'Project created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
       'title' => ['required', 'string', 'max:255'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'location' => ['nullable', 'string', 'max:255'],
        'event_date' => ['nullable', 'date'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'goal_amount' => ['nullable', 'numeric'],
        'raised_amount' => ['nullable', 'numeric'],
        'status' => ['required', 'string'],
        'featured' => ['nullable', 'boolean'],
        
    ]);

    // Update slug if title changed
    if ($event->title !== $validated['title']) {

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;

        while (
            Event::where('slug', $slug)
                ->where('id', '!=', $event->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;
    }
        $validated['image'] = $event->image;
    if ($request->hasFile('image')) {

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
          $path =  $validated['image'] = $request->file('image')
            ->store('events', 'public');
            $validated['image'] = $path;
    }
  
    $validated['featured'] = $request->boolean('featured');
    $event->update($validated);
        return redirect()->back()->with('message', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Event $cause)
    {
        $cause->delete();
        return redirect()->back()->with('message', 'Project deleted successfully.');
    }
}
