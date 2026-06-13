<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectController extends Controller
{
    // READ: Load the page with data
    public function index()
    {
        // Fetch all projects, ordered by newest first
        $projects = Project::latest()->get();

        // Pass the data to the Vue component
        return Inertia::render('Admin/Project/Projects', [
            'projects' => $projects,
        ]);
    }
    // CREATE: Save a new project
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location'          => ['nullable', 'string', 'max:255'],
            'budget'            => ['nullable', 'numeric'],
            'raised_amount'     => ['nullable', 'numeric'],
            'status'            => ['required', 'string'],
            'start_date'        => ['nullable', 'date'],
            'end_date'          => ['nullable', 'date'],
            'featured'          => ['nullable', 'boolean'],
        ]);

        if (empty($validated['short_description']) && !empty($validated['description'])) {
            // 1. strip_tags() removes any HTML (like <b> or <p> tags)
            // 2. Str::limit() cuts it off at 150 characters and adds "..." at the end
            $validated['short_description'] = Str::limit(strip_tags($validated['description']), 150);
        }

        
        // Generate slug automatically
        $validated['slug'] = Str::slug($validated['title']);

        // Make slug unique
        $originalSlug = $validated['slug'];
        $count        = 1;

        while (Project::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            $path = $validated['image'] = $request->file('image')
                ->store('projects', 'public');
            $validated['image'] = $path;
        }

        $validated['featured'] = $request->boolean('featured');

        Project::create($validated);

        // Inertia automatically redirects back to the index page with fresh data
        return redirect()->back()->with('message', 'Project created successfully.');
    }

    // UPDATE: Modify an existing project
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location'          => ['nullable', 'string', 'max:255'],
            'budget'            => ['nullable', 'numeric'],
            'raised_amount'     => ['nullable', 'numeric'],
            'status'            => ['required', 'string'],
            'start_date'        => ['nullable', 'date'],
            'end_date'          => ['nullable', 'date'],
            'featured'          => ['nullable', 'boolean'],

        ]);

        if (empty($validated['short_description']) && !empty($validated['description'])) {
            // 1. strip_tags() removes any HTML (like <b> or <p> tags)
            // 2. Str::limit() cuts it off at 150 characters and adds "..." at the end
            $validated['short_description'] = Str::limit(strip_tags($validated['description']), 150);
        }


        // Update slug if title changed
        if ($project->title !== $validated['title']) {
            $slug         = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count        = 1;

            while (
                Project::where('slug', $slug)
                ->where('id', '!=', $project->id)
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        }

        $validated['image'] = $project->image;

        if ($request->hasFile('image')) {

            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            $path = $validated['image'] = $request->file('image')
                ->store('projects', 'public');
            $validated['image'] = $path;
        }

        $validated['featured'] = $request->boolean('featured');

        $project->update($validated);

        return redirect()->back()->with('message', 'Project updated successfully.');
    }

    // DELETE: Remove a project
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('message', 'Project deleted successfully.');
    }
}
