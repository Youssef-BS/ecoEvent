<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Event;
use App\Models\Sponsor;

class FeedbackController extends Controller
{


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ratings' => 'required|array',
            'ratings.*' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        foreach ($validated['ratings'] as $resourceId => $rating) {
            if ($rating > 0) {
                $feedback = Feedback::create([
                    'event_id' => $validated['event_id'],
                    'resource_id' => $resourceId,
                    'sponsor_id' => $request->input("sponsor_ids.$resourceId"),
                    'rating' => $rating,
                    'comment' => $validated['comment'] ?? null,
                ]);


                $sponsor = Sponsor::find($feedback->sponsor_id);
                if ($sponsor) {
                    $sponsor->updateMetricsFromFeedback();
                }
            }
        }

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
}
