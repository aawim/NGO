<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CausesController extends Controller
{
       public function index()
    {
        // Fetch all projects, ordered by newest first
        $causes = Cause::latest()->get(); 
        // Pass the data to the Vue component
        return Inertia::render('Admin/Causes/Causes', [
            'causes' => $causes
        ]);
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'location' => ['nullable', 'string', 'max:255'],
        'budget' => ['nullable', 'numeric'],
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

    while (Cause::where('slug', $validated['slug'])->exists()) {
        $validated['slug'] = $originalSlug . '-' . $count++;
    }

    if ($request->hasFile('image')) {

    $path =  $validated['image'] = $request->file('image')
            ->store('causes', 'public');
            $validated['image'] = $path;
    }

   
    $validated['featured'] = $request->boolean('featured');

    Cause::create($validated);

        // Inertia automatically redirects back to the index page with fresh data
        return redirect()->back()->with('message', 'Project created successfully.');
    }


     // UPDATE: Modify an existing project
    public function update(Request $request, Cause $cause)
    {
        $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'goal_amount' => ['nullable', 'numeric'],
        'raised_amount' => ['nullable', 'numeric'],
        'status' => ['required', 'string'],
        'featured' => ['nullable', 'boolean'],
        
    ]);

    // Update slug if title changed
    if ($cause->title !== $validated['title']) {

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;

        while (
            Cause::where('slug', $slug)
                ->where('id', '!=', $cause->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;
    }
 $validated['image'] = $cause->image;
    if ($request->hasFile('image')) {

        if ($cause->image && Storage::disk('public')->exists($cause->image)) {
            Storage::disk('public')->delete($cause->image);
        }
          $path =  $validated['image'] = $request->file('image')
            ->store('causes', 'public');
            $validated['image'] = $path;
    }

   
    $validated['featured'] = $request->boolean('featured');
    $cause->update($validated);
        return redirect()->back()->with('message', 'Project updated successfully.');
    }
        public function destroy(Cause $cause)
    {
        $cause->delete();
        return redirect()->back()->with('message', 'Project deleted successfully.');
    }
    
}
