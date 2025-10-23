<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Resource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventResourceController extends Controller
{
    public function edit(Event $event)
    {
        $event->load('resources');
        $existing = $event->resources->pluck('pivot.quantity', 'id')->toArray();
        $resources = Resource::with('sponsor')->get();

        Log::info('Edit EventResource', [
            'event_id' => $event->id,
            'existing_resources' => $existing,
            'resources_count' => $resources->count()
        ]);

        return view('events.selectResouce', compact('event', 'resources', 'existing'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'nullable|integer|min:0',
        ]);

        $quantities = $request->input('quantities', []);

        Log::info('Update EventResource called', [
            'event_id' => $event->id,
            'input_quantities' => $quantities
        ]);

        try {
            DB::transaction(function () use ($event, $quantities) {

                $existing = $event->resources->pluck('pivot.quantity', 'id')->toArray();
                Log::info('Existing pivot quantities', $existing);

                $resourceIds = array_unique(array_merge(array_keys($existing), array_keys($quantities)));
                $resources = Resource::whereIn('id', $resourceIds)->lockForUpdate()->get()->keyBy('id');

                Log::info('Resources loaded', [
                    'resource_ids' => $resources->keys()->toArray()
                ]);

                $sync = [];

                foreach ($quantities as $rid => $qty) {
                    $qty = (int)$qty;
                    $res = $resources->get($rid);

                    if (!$res) {
                        Log::warning("Resource #$rid not found");
                        continue;
                    }

                    $existingQty = $existing[$rid] ?? 0;
                    $diff = $qty - $existingQty;

                    Log::info("Processing resource {$res->title}", [
                        'resource_id' => $rid,
                        'existing_qty' => $existingQty,
                        'new_qty' => $qty,
                        'diff' => $diff,
                        'available_stock' => $res->quantity
                    ]);

                    if ($diff > 0 && $res->quantity < $diff) {
                        throw new \Exception("Stock insuffisant pour la ressource: {$res->title}");
                    }

                    if ($diff > 0) $res->decrement('quantity', $diff);
                    elseif ($diff < 0) $res->increment('quantity', -$diff);

                    if ($qty > 0) {
                        $sync[$rid] = [
                            'quantity' => $qty,
                            'sponsor_id' => $res->sponsor_id
                        ];
                    }
                }

                // remettre en stock les ressources non sélectionnées
                foreach ($existing as $rid => $existingQty) {
                    if (!isset($sync[$rid])) {
                        $res = $resources->get($rid);
                        if ($res) {
                            $res->increment('quantity', $existingQty);
                            Log::info("Restocked resource {$res->title}", [
                                'quantity' => $existingQty
                            ]);
                        }
                    }
                }

                Log::info('Sync pivot', $sync);
                $event->resources()->sync($sync);

                // mettre à jour metrics des sponsors
                $sponsorIds = collect($sync)->pluck('sponsor_id')->unique();
                foreach ($sponsorIds as $sid) {
                    $sponsor = Sponsor::find($sid);
                    if ($sponsor) {
                        $sponsor->updateMetricsFromFeedback();
                        Log::info("Updated sponsor metrics", ['sponsor_id' => $sid]);
                    }
                }
            });

            Log::info('Update EventResource successful', ['event_id' => $event->id]);

            return redirect()->route('events.show', $event->id)
                ->with('success', 'Resources successfully reserved.');
        } catch (\Exception $e) {
            Log::error('Update EventResource failed', [
                'event_id' => $event->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
