<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NewsStory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsStoryController extends Controller
{
    public function index()
    {
        $stories = NewsStory::with('user')->latest()->get();
        return Inertia::render('Admin/NewsStories/NewsStories', [
            'stories' => $stories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        $validated['user_id'] = auth()->id();
        
        // Generate Slug
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Handle Status & Published Date
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        // Parse comma-separated strings into arrays for JSON columns
        $validated['categories'] = $this->parseCommaSeparated($request->categories);
        $validated['tags'] = $this->parseCommaSeparated($request->tags);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        NewsStory::create($validated);

        return redirect()->back()->with('message', 'Story published successfully.');
    }

    public function update(Request $request, NewsStory $newsStory)
    {
        $validated = $this->validateForm($request);

        // Update Slug if title changed
        if ($newsStory->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $newsStory->id);
        }

        // Handle Publishing Date Logic
        if ($validated['status'] === 'published' && !$newsStory->published_at) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] !== 'published') {
            $validated['published_at'] = null;
        }

        $validated['categories'] = $this->parseCommaSeparated($request->categories);
        $validated['tags'] = $this->parseCommaSeparated($request->tags);
        $validated['featured_image'] = $newsStory->featured_image;

        if ($request->hasFile('featured_image')) {
            if ($newsStory->featured_image && Storage::disk('public')->exists($newsStory->featured_image)) {
                Storage::disk('public')->delete($newsStory->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $newsStory->update($validated);

        return redirect()->back()->with('message', 'Story updated successfully.');
    }

    public function destroy(NewsStory $newsStory)
    {
        $newsStory->delete(); // Soft delete based on your schema
        return redirect()->back()->with('message', 'Story moved to trash.');
    }

    // --- Private Helpers ---

    private function validateForm(Request $request)
    {
        return $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'type'               => ['required', 'in:news,story,press_release,event_update,impact_report'],
            'status'             => ['required', 'in:draft,review,published,archived'],
            'content'            => ['required', 'string'],
            'excerpt'            => ['nullable', 'string', 'max:500'],
            'location'           => ['nullable', 'string', 'max:255'],
            'event_date'         => ['nullable', 'date'],
            'featured'           => ['boolean'],
            'featured_image'     => ['nullable', 'image', 'max:2048'],
            // Categories/Tags come in as comma separated strings from the frontend
            'categories'         => ['nullable', 'string'],
            'tags'               => ['nullable', 'string'],
        ]);
    }

    private function parseCommaSeparated($string)
    {
        if (!$string) return null;
        return array_map('trim', explode(',', $string));
    }

    private function generateUniqueSlug($title, $ignoreId = 0)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        while (NewsStory::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        return $slug;
    }
}