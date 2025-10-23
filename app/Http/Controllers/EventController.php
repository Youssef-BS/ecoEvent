<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{


    public function index(Request $request)

    {
        $query = Event::with('user')->withCount('participants')->latest('date');

        // Location filtering restricted to configured governorates list
        $locationInput = trim((string) $request->query('location'));
        if ($locationInput !== '') {
            $governorates = config('events.governorates', []);

            $normalizedMap = collect($governorates)
                ->mapWithKeys(fn($g) => [mb_strtolower($g) => $g]);
            $key = mb_strtolower($locationInput);
            if ($normalizedMap->has($key)) {
                $query->where('location', $normalizedMap->get($key));
            }
        }

        $events = $query->paginate(6)->appends($request->only('location'));

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
        return redirect()
            ->route('events.resources.edit', $event->id)
            ->with('success', 'Événement créé avec succès ! Sélectionnez maintenant les ressources.');
    }


    public function show(Event $event)
    {
        $event->load(['reviews.user']);
        // averageRating accessor returns null if relation not loaded; we loaded it above
        $averageRating = $event->average_rating; // dynamic attribute
        return view('events.show', compact('event', 'averageRating'));
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


    public function attachResources(Request $request, Event $event)
    {
        $resourceIds = $request->input('resource_ids', []);

        // Mettre à jour event_id des ressources sélectionnées
        Resource::whereIn('id', $resourceIds)->update(['event_id' => $event->id]);

        // Supprimer le lien pour les ressources décochées
        Resource::where('event_id', $event->id)
            ->whereNotIn('id', $resourceIds)
            ->update(['event_id' => null]);

        return redirect()->route('events.index')->with('success', 'Resources attached successfully.');
    }
}
