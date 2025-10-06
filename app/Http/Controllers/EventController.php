<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
   
    public function index()
    {
        $events = Event::with('user')->latest('date')->paginate(6);
        return view('client.event', compact('events'));
    }

    
    public function create()
    {
        $this->authorizeAction();
        return view('events.create');
    }

    
    public function store(Request $request)
    {
        $this->authorizeAction();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|string|in:' . implode(',', config('events.categories')),
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'date' => 'required|date',
            'location' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== null && $value !== '' && !in_array($value, config('events.governorates'))) {
                    $fail('The selected location is invalid.');
                }
            }],
            'price' => 'nullable|integer|min:0',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public'); 
        }

        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'categories' => $validated['categories'],
            'image' => $path,
            'date' => $validated['date'],
            'location' => $validated['location'] ?? null,
            'price' => $validated['price'] ?? 0,
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Event created successfully.');
    }

   
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

   
    public function edit(Event $event)
    {
        $this->authorizeOwner($event);
        return view('events.edit', compact('event'));
    }

    
    public function update(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|string|in:' . implode(',', config('events.categories')),
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'date' => 'required|date',
            'location' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== null && $value !== '' && !in_array($value, config('events.governorates'))) {
                    $fail('The selected location is invalid.');
                }
            }],
            'price' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');
    }

   
    public function destroy(Event $event)
    {
        $this->authorizeOwner($event);
        $event->delete();
        return redirect()->route('event')->with('success', 'Event deleted successfully.');
    }

    private function authorizeAction(): void
    {
        if (!Auth::check()) {
            abort(403);
        }
    }

    private function authorizeOwner(Event $event): void
    {
        if (!Auth::check() || Auth::id() !== (int) $event->user_id) {
            abort(403);
        }
    }
}
