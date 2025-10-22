<?php

Route::get('/metrics', function () {
    $metrics = [];
    
    // Basic metrics in Prometheus format
    $metrics[] = "# HELP app_uptime Application uptime seconds";
    $metrics[] = "# TYPE app_uptime gauge";
    $metrics[] = "app_uptime " . (microtime(true) - LARAVEL_START);
    
    $metrics[] = "# HELP app_memory_usage Memory usage bytes";
    $metrics[] = "# TYPE app_memory_usage gauge";
    $metrics[] = "app_memory_usage " . memory_get_usage(true);
    
    $metrics[] = "# HELP app_memory_peak Peak memory usage bytes";
    $metrics[] = "# TYPE app_memory_peak gauge";
    $metrics[] = "app_memory_peak " . memory_get_peak_usage(true);
    
    // Database status
    try {
        \Illuminate\Support\Facades\DB::select('SELECT 1');
        $db_status = 1;
    } catch (Exception $e) {
        $db_status = 0;
    }
    
    $metrics[] = "# HELP app_database_status Database connection status";
    $metrics[] = "# TYPE app_database_status gauge";
    $metrics[] = "app_database_status " . $db_status;
    
    return response(implode("\n", $metrics), 200)
        ->header('Content-Type', 'text/plain');
});