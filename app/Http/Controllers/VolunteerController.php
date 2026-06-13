<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the user relationship
        $volunteers = Volunteer::with('user')->latest()->get();

        // Fetch all users to populate the admin dropdown
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        $skills = [
            'Medical',
            'First Aid',
            'Nursing',
            'IT Support',
            'Web Development',
            'Logistics',
            'Heavy Machinery',
            'Spanish Translation',
            'Event Organization',
            'Public Speaking',
            'Teaching',
            'Childcare',
            'Art Therapy',
        ];

        return Inertia::render('Admin/Volunteers/Volunteers', [
            'volunteers' => $volunteers,
            'users'      => $users, // Pass users to Vue
            'skills'     => $skills,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => ['nullable', 'exists:users,id'], // Validate user_id
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:volunteers,email'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'skills'       => ['nullable', 'array'],
            'availability' => ['required', 'string'],
            'status'       => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {

            $path = $validated['image'] = $request->file('image')
                ->store('volunteers', 'public');
            $validated['image'] = $path;
        }
        $validated['image'] = $path;

        Volunteer::create($validated);

        return redirect()->back()->with('message', 'Volunteer added successfully.');
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $validated = $request->validate([
            'user_id'      => ['nullable', 'exists:users,id'], // Validate user_id
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:volunteers,email,' . $volunteer->id],
            'phone'        => ['nullable', 'string', 'max:50'],
            'skills'       => ['nullable', 'array'],
            'availability' => ['required', 'string'],
            'status'       => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['image'] = $volunteer->image;
        if ($request->hasFile('image')) {

            if ($volunteer->image && Storage::disk('public')->exists($volunteer->image)) {
                Storage::disk('public')->delete($volunteer->image);
            }
            $path = $validated['image'] = $request->file('image')
                ->store('volunteers', 'public');
            $validated['image'] = $path;
        }

        $volunteer->update($validated);

        return redirect()->back()->with('message', 'Volunteer updated successfully.');
    }

    public function destroy(string $id)
    {
        //
    }
}
