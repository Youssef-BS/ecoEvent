<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackCacheMetrics
{
    public function handle(Request $request, Closure $next)
    {
        // Track request count
        Cache::increment('metrics_total_requests');
        
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // You can track response time here if needed
        $responseTime = microtime(true) - LARAVEL_START;
        
        Cache::put('metrics_last_response_time', $responseTime);
    }
}