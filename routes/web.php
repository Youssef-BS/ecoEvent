<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventResourceController;
use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Cache;

// // CLIENT ROUTES
// Route::get('/', fn() => view('client.index'))->name('home');
Route::get('/', [SponsorController::class, 'home'])->name('home');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/about', fn() => view('client.about'))->name('about');
Route::get('/contact', fn() => view('client.contact'))->name('contact');
Route::get('/donation', [DonationController::class, 'index'])->name('donation');
// Events listing (dynamic)
Route::get('/event', [EventController::class, 'index'])->name('event');
Route::get('/feature', fn() => view('client.feature'))->name('feature');
Route::get('/service', fn() => view('client.service'))->name('service');
Route::get('/team', fn() => view('client.team'))->name('team');
Route::get('/testimonial', fn() => view('client.testimonial'))->name('testimonial');


Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [UserController::class, 'showProfile'])
    ->middleware('auth')
    ->name('profile.show');

Route::get('/admin', function () {
    return view('admin.layouts.dashboard');
})->middleware(['auth'])->name('admin.dashboard');


// Event CRUD (auth required for create/edit/delete)
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Public show route
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('events/{event}/resources', [EventResourceController::class, 'edit'])->name('events.resources.edit');
Route::put('events/{event}/resources', [EventResourceController::class, 'update'])->name('events.resources.update');
/**************************sponsor */
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.ListeSponsor');


Route::post('/sponsors', [SponsorController::class, 'store'])->name('sponsors.store');


Route::get('/sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
Route::get('/sponsors/{sponsor}', [SponsorController::class, 'show'])->name('sponsors.show');
Route::get('/sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
Route::put('/sponsors/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
Route::delete('/sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');


Route::resource('resources', ResourceController::class);
Route::middleware('auth')->group(function () {
    // Messages
    Route::get('/messagerie', [MessagerieController::class, 'index'])->name('messagerie.index');
    Route::get('/messagerie/create', [MessagerieController::class, 'create'])->name('messagerie.create');
    Route::post('/messagerie', [MessagerieController::class, 'store'])->name('messagerie.store');
    Route::get('/messagerie/{userId}', [MessagerieController::class, 'show'])->name('messagerie.show');
    Route::delete('/messagerie/{messagerie}', [MessagerieController::class, 'destroy'])->name('messagerie.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->names([
        'index' => 'post.all',
        'show'  => 'post.view',
        'create' => 'post.new',
        'store' => 'post.store',
        'edit'  => 'post.edit',
        'update' => 'post.update',
        'destroy' => 'post.delete',
    ]);
});

Route::get('/admin/donations', [DonationController::class, 'adminIndex'])->name('donations.adminIndex');
Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
Route::put('/donations/{id}', [DonationController::class, 'update'])->name('donations.update');
Route::delete('/donations/{id}', [DonationController::class, 'destroy'])->name('donations.destroy');






Route::prefix('/events/{event}/products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

// In routes/web.php
Route::get('/metrics', function () {
    $metrics = [];
    
    // ===== SYSTEM METRICS =====
    $metrics[] = "# HELP app_uptime Application uptime seconds";
    $metrics[] = "# TYPE app_uptime gauge";
    $metrics[] = "app_uptime " . (microtime(true) - LARAVEL_START);
    
    $metrics[] = "# HELP app_memory_usage Memory usage bytes";
    $metrics[] = "# TYPE app_memory_usage gauge";
    $metrics[] = "app_memory_usage " . memory_get_usage(true);
    
    $metrics[] = "# HELP app_memory_peak Peak memory usage bytes";
    $metrics[] = "# TYPE app_memory_peak gauge";
    $metrics[] = "app_memory_peak " . memory_get_peak_usage(true);
    
    // ===== DATABASE METRICS =====
    try {
        \Illuminate\Support\Facades\DB::select('SELECT 1');
        $db_status = 1;
        
        // Get table counts if possible
        $users_count = 0;
        $posts_count = 0;
        try {
            if (class_exists('App\\Models\\User')) {
                $users_count = \App\Models\User::count();
            }
            if (class_exists('App\\Models\\Post')) {
                $posts_count = \App\Models\Post::count();
            }
        } catch (Exception $e) {
            // Ignore if tables don't exist
        }
        
    } catch (Exception $e) {
        $db_status = 0;
        $users_count = 0;
        $posts_count = 0;
    }
    
    $metrics[] = "# HELP app_database_status Database connection status";
    $metrics[] = "# TYPE app_database_status gauge";
    $metrics[] = "app_database_status " . $db_status;
    
    $metrics[] = "# HELP app_users_total Total number of users";
    $metrics[] = "# TYPE app_users_total gauge";
    $metrics[] = "app_users_total " . $users_count;
    
    $metrics[] = "# HELP app_posts_total Total number of posts";
    $metrics[] = "# TYPE app_posts_total gauge";
    $metrics[] = "app_posts_total " . $posts_count;
    
    // ===== CACHE METRICS =====
    $cache_hits = Cache::get('metrics_cache_hits', 0);
    $cache_misses = Cache::get('metrics_cache_misses', 0);
    
    $metrics[] = "# HELP app_cache_hits_total Total cache hits";
    $metrics[] = "# TYPE app_cache_hits_total counter";
    $metrics[] = "app_cache_hits_total " . $cache_hits;
    
    $metrics[] = "# HELP app_cache_misses_total Total cache misses";
    $metrics[] = "# TYPE app_cache_misses_total counter";
    $metrics[] = "app_cache_misses_total " . $cache_misses;
    
    // Calculate cache hit rate
    $total_requests = $cache_hits + $cache_misses;
    $cache_hit_rate = $total_requests > 0 ? ($cache_hits / $total_requests) * 100 : 0;
    
    $metrics[] = "# HELP app_cache_hit_rate Cache hit rate percentage";
    $metrics[] = "# TYPE app_cache_hit_rate gauge";
    $metrics[] = "app_cache_hit_rate " . $cache_hit_rate;
    
    // ===== REQUEST METRICS =====
    $total_requests = Cache::increment('metrics_total_requests');
    $metrics[] = "# HELP app_http_requests_total Total HTTP requests";
    $metrics[] = "# TYPE app_http_requests_total counter";
    $metrics[] = "app_http_requests_total " . $total_requests;
    
    // ===== STORAGE METRICS =====
    try {
        $storage_path = storage_path();
        $total_space = disk_total_space($storage_path);
        $free_space = disk_free_space($storage_path);
        $used_space = $total_space - $free_space;
        $disk_usage_percent = ($used_space / $total_space) * 100;
        
        $metrics[] = "# HELP app_disk_usage_bytes Disk usage in bytes";
        $metrics[] = "# TYPE app_disk_usage_bytes gauge";
        $metrics[] = "app_disk_usage_bytes " . $used_space;
        
        $metrics[] = "# HELP app_disk_usage_percent Disk usage percentage";
        $metrics[] = "# TYPE app_disk_usage_percent gauge";
        $metrics[] = "app_disk_usage_percent " . $disk_usage_percent;
        
    } catch (Exception $e) {
        // Ignore disk space errors
    }
    
    // ===== QUEUE METRICS (if using queues) =====
    try {
        $failed_jobs = class_exists('Illuminate\\Support\\Facades\\Queue') ? 
            \Illuminate\Support\Facades\DB::table('failed_jobs')->count() : 0;
        
        $metrics[] = "# HELP app_queue_failed_jobs_total Total failed queue jobs";
        $metrics[] = "# TYPE app_queue_failed_jobs_total gauge";
        $metrics[] = "app_queue_failed_jobs_total " . $failed_jobs;
        
    } catch (Exception $e) {
        // Ignore if queues aren't set up
    }
    
    // ===== PHP METRICS =====
    $metrics[] = "# HELP app_php_version PHP version as metric";
    $metrics[] = "# TYPE app_php_version gauge";
    $metrics[] = "app_php_version " . str_replace('.', '', PHP_VERSION);
    
    $metrics[] = "# HELP app_loaded_extensions PHP loaded extensions count";
    $metrics[] = "# TYPE app_loaded_extensions gauge";
    $metrics[] = "app_loaded_extensions " . count(get_loaded_extensions());
    
    return response(implode("\n", $metrics), 200)
        ->header('Content-Type', 'text/plain');
});