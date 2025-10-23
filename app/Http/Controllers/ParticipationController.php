<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    /**
     * Register the authenticated user to an event with submitted contact info.
     */
    public function store(Request $request, Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to register for this event.');
        }

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        // Avoid duplicate registrations for the same user
        $exists = $event->participants()->where('users.id', Auth::id())->exists();
        if ($exists) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $event->participants()->attach(Auth::id(), [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        return back()->with('success', 'Registration successful!');
    }

    /**
     * Unregister the authenticated user from the event.
     */
    public function destroy(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $event->participants()->detach(Auth::id());
        return back()->with('success', 'You have been unregistered from this event.');
    }
}
