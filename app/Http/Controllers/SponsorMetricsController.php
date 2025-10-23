<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsor;

class SponsorMetricsController extends Controller
{

    public function updateAll()
    {
        $sponsors = Sponsor::all();

        foreach ($sponsors as $sponsor) {
            $sponsor->updateMetrics();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Métriques et scores des sponsors mis à jour !'
        ]);
    }


    public function getMetrics()
    {
        $sponsors = Sponsor::all()->map(function ($sponsor) {
            return [
                'name' => $sponsor->name,
                'events_sponsored_count' => $sponsor->events_sponsored_count,
                'avg_satisfaction' => $sponsor->avg_satisfaction,
                'impact_score' => $sponsor->impact_score,
                'performance_level' => $sponsor->performance_level,
            ];
        });

        return response()->json($sponsors);
    }
}
