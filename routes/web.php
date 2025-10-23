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

use App\Http\Controllers\ParticipationController;

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;


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

    // Reviews CRUD (nested create; standalone update/delete)
    Route::post('/events/{event}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Event participation
    Route::post('/events/{event}/participations', [ParticipationController::class, 'store'])->name('participations.store');
    Route::delete('/events/{event}/participations', [ParticipationController::class, 'destroy'])->name('participations.destroy');
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
    Route::get('/messagerie/unread/count', [MessagerieController::class, 'getUnreadCount'])->name('messagerie.unread-count');
    Route::post('/messagerie/typing', [MessagerieController::class, 'typing'])->name('messagerie.typing');


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
        'create'=> 'post.new',
        'store' => 'post.store',
        'edit'  => 'post.edit',
        'update' => 'post.update',
        'destroy' => 'post.delete',
    ]);
});

Route::middleware('auth')->group(function () {
   // Comments routes
   Route::get('/posts/{post}/comments', [CommentController::class, 'getComments'])->name('comments.getComments');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
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

Route::prefix('/admin/users')->name('users.')->group(function () {
    Route::get('/all', [UserController::class, 'listUsers'])->name('listUsers');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store'); 
    Route::get('/user/{id}', [UserController::class, 'showProfile'])->name('showProfile');
    Route::put('/{user}', [UserController::class, 'edit'])->name('edit');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
