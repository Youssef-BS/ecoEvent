<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review for an event.
     */
    public function store(Request $request, Event $event)
    {
        $this->authorizeAction();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // Prevent duplicate reviews by same user (optional business rule)
        $existing = Review::where('event_id', $event->id)->where('user_id', Auth::id())->first();
        if ($existing) {
            return redirect()->route('events.show', $event)->with('error', 'You have already reviewed this event.');
        }

        Review::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'created_at' => now(),
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Review added successfully.');
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review)
    {
        $this->authorizeOwner($review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $review->update($validated);

        return redirect()->route('events.show', $review->event)->with('success', 'Review updated.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $this->authorizeOwner($review);
        $event = $review->event;
        $review->delete();
        return redirect()->route('events.show', $event)->with('success', 'Review deleted.');
    }

    private function authorizeAction(): void
    {
        if (!Auth::check()) {
            abort(403);
        }
    }

    private function authorizeOwner(Review $review): void
    {
        if (!Auth::check() || Auth::id() !== (int) $review->user_id) {
            abort(403);
        }
    }
}
