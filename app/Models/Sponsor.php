<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Feedback;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'contribution',
        'email',
        'phone',
        'website',
        'logo',
        'avg_satisfaction',
        'events_sponsored_count',
        'impact_score',
        'performance_level'
    ];

    protected $casts = [
        'avg_satisfaction' => 'float',
        'events_sponsored_count' => 'integer',
        'impact_score' => 'float',
        'performance_level' => 'string'
    ];


    public function resources()
    {
        return $this->hasMany(Resource::class);
    }


    public function feedbacks()
    {
        return $this->hasManyThrough(
            Feedback::class,
            Resource::class,
            'sponsor_id',
            'resource_id',
            'id',
            'id'
        );
    }

    public function calculateAvgSatisfaction(): float
    {

        $avg = Feedback::join('resources', 'feedbacks.resource_id', '=', 'resources.id')
            ->where('resources.sponsor_id', $this->id)
            ->avg('feedbacks.rating');

        return $avg ?? 0;
    }


    public function eventsViaResources()
    {
        return DB::table('events')
            ->join('event_resource', 'events.id', '=', 'event_resource.event_id')
            ->join('resources', 'resources.id', '=', 'event_resource.resource_id')
            ->where('resources.sponsor_id', $this->id)
            ->select('events.*')
            ->distinct();
    }


    public function updateMetricsFromFeedback()
    {
        $avgSatisfaction = $this->calculateAvgSatisfaction();
        $eventsCount = $this->eventsViaResources()->count();


        $impactScore = round(
            0.7 * min($avgSatisfaction / 5, 1) * 100 +
                0.3 * min($eventsCount / 10, 1) * 100,
            2
        );


        if ($impactScore >= 70) {
            $performanceLevel = 'Top Performer';
        } elseif ($impactScore >= 40) {
            $performanceLevel = 'Potentiel élevé';
        } else {
            $performanceLevel = 'À relancer';
        }


        $this->update([
            'avg_satisfaction' => $avgSatisfaction,
            'events_sponsored_count' => $eventsCount,
            'impact_score' => $impactScore,
            'performance_level' => $performanceLevel,
        ]);

        logger("Sponsor {$this->name}: avgSatisfaction={$avgSatisfaction}, events={$eventsCount}, impactScore={$impactScore}, performanceLevel={$performanceLevel}");
    }
}
