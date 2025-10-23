<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalSponsors = Sponsor::count();
        $totalResources = Resource::count();
        $totalEventsSponsored = DB::table('event_resource')->count();

        // Graphiques simplifiés
        $sponsorsLabels = Sponsor::pluck('name')->toArray();
        $resourcesCount = Sponsor::withCount('resources')->pluck('resources_count')->toArray();

        $performanceLabels = Sponsor::select('performance_level')->distinct()->pluck('performance_level')->toArray();
        $performanceData = Sponsor::select('performance_level', DB::raw('count(*) as total'))
            ->groupBy('performance_level')
            ->pluck('total')
            ->toArray();

        // Retourne la vue avec toutes les variables
        return view('admin.layouts.dashboard', compact(
            'totalSponsors',
            'totalResources',
            'totalEventsSponsored',
            'sponsorsLabels',
            'resourcesCount',
            'performanceLabels',
            'performanceData'
        ));
    }
}
