<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReply;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        // Fetch all messages, newest first. Load the user if one is attached.
        $messages = Contact::with(['user', 'replies.user'])->latest()->get();

        return Inertia::render('Admin/ContactMessages/ContactMessages', [
            'messages' => $messages
        ]);
    }

    public function updateStatus(Request $request, Contact $message)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,read,resolved']
        ]);

        $message->update(['status' => $validated['status']]);

        return redirect()->back()->with('message', 'Message status updated.');
    }

    public function destroy(Contact $message)
    {
        $message->delete();

        return redirect()->back()->with('message', 'Message deleted successfully.');
    }

    public function reply(Request $request, Contact $message)
    {
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'min:5'],
        ]);

        $message->replies()->create([
            'user_id' => auth()->id(), // The logged-in admin
            'body'    => $validated['reply_message']
        ]);
        
        // Send the email using Laravel's Mail facade
        Mail::to($message->email)->send(new ContactMessageReply($message, $validated['reply_message']));

        // Automatically mark the message as resolved since we replied!
        $message->update(['status' => 'resolved']);

        return redirect()->back()->with('message', 'Reply successfully sent to ' . $message->email);
    }
}
