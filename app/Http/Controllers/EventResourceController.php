<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventResourceController extends Controller
{
    public function edit(Event $event)
    {
        $event->load('resources'); // ressources déjà réservées
        $existing = $event->resources->pluck('pivot.quantity', 'id')->toArray();
        $resources = Resource::with('sponsor')->get();

        return view('events.selectResouce', compact('event', 'resources', 'existing'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'nullable|integer|min:0',
        ]);

        $newQuantities = array_map('intval', $request->input('quantities', [])); // id => qty

        try {
            DB::transaction(function () use ($event, $newQuantities) {
                // existing reservations
                $existing = $event->resources->pluck('pivot.quantity', 'id')->toArray();

                // resources involved (existing or new)
                $resourceIds = array_unique(array_merge(array_keys($existing), array_keys($newQuantities)));

                // lock rows
                $resources = Resource::whereIn('id', $resourceIds)->lockForUpdate()->get()->keyBy('id');

                $sync = [];

                // handle each requested resource
                foreach ($newQuantities as $rid => $qty) {
                    $qty = (int)$qty;
                    $existingQty = $existing[$rid] ?? 0;
                    $res = $resources->get($rid);

                    if (!$res) {
                        throw new \Exception("Resource #{$rid} not found.");
                    }

                    $diff = $qty - $existingQty;

                    if ($diff > 0) {
                        // try to reserve additional units
                        if ($res->quantity < $diff) {
                            throw new \Exception("Stock insuffisant pour la ressource: {$res->title}");
                        }
                        $res->decrement('quantity', $diff);
                    } elseif ($diff < 0) {
                        // release some units back to stock
                        $res->increment('quantity', -$diff);
                    }

                    if ($qty > 0) {
                        $sync[$rid] = ['quantity' => $qty];
                    }
                }

                // resources previously reserved but now absent in newQuantities -> release
                foreach ($existing as $rid => $existingQty) {
                    if (!isset($newQuantities[$rid]) || (int)$newQuantities[$rid] === 0) {
                        $res = $resources->get($rid);
                        if ($res) {
                            $res->increment('quantity', $existingQty);
                        }
                    }
                }

                // sync pivot with new mapping (this will replace old pivot data)
                $event->resources()->sync($sync);
            });

            return redirect()->route('events.show', $event->id)->with('success', 'Resources successfully reserved.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
