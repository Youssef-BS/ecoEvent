<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    PostController,
    UserController,
    EventController,
    ProductController,
    SponsorController,
    DonationController,
    EventResourceController,
    MessagerieController,
    NotificationController,
    ResourceController,
    CommentController,
    LikeController
};

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [SponsorController::class, 'home'])->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/about', 'client.about')->name('about');
Route::view('/contact', 'client.contact')->name('contact');
Route::view('/feature', 'client.feature')->name('feature');
Route::view('/service', 'client.service')->name('service');
Route::view('/team', 'client.team')->name('team');
Route::view('/testimonial', 'client.testimonial')->name('testimonial');

// Donations (public)
Route::get('/donation', [DonationController::class, 'index'])->name('donation');

// Events (public)
Route::get('/event', [EventController::class, 'index'])->name('event');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Auth
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/admin', fn() => view('admin.layouts.dashboard'))
    ->middleware('auth')
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| EVENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Event resources
    Route::get('/events/{event}/resources', [EventResourceController::class, 'edit'])->name('events.resources.edit');
    Route::put('/events/{event}/resources', [EventResourceController::class, 'update'])->name('events.resources.update');
});

/*
|--------------------------------------------------------------------------
| SPONSORS
|--------------------------------------------------------------------------
*/
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');
Route::get('/sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
Route::post('/sponsors', [SponsorController::class, 'store'])->name('sponsors.store');
Route::get('/sponsors/{sponsor}', [SponsorController::class, 'show'])->name('sponsors.show');
Route::get('/sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
Route::put('/sponsors/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
Route::delete('/sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');

/*
|--------------------------------------------------------------------------
| RESOURCES
|--------------------------------------------------------------------------
*/
Route::resource('resources', ResourceController::class)->middleware('auth');

/*
|--------------------------------------------------------------------------
| MESSAGERIE & NOTIFICATIONS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Messagerie
    Route::get('/messagerie', [MessagerieController::class, 'index'])->name('messagerie.index');
    Route::get('/messagerie/recent', [MessagerieController::class, 'recent'])->name('messagerie.recent');
    Route::get('/messagerie/create', [MessagerieController::class, 'create'])->name('messagerie.create');
    Route::post('/messagerie', [MessagerieController::class, 'store'])->name('messagerie.store');

    // ✅ FIXED: Changed route to match JavaScript call
    Route::get('/messagerie/unread/count', [MessagerieController::class, 'getUnreadCount'])->name('messagerie.unread-count');

    Route::post('/messagerie/typing', [MessagerieController::class, 'typing'])->name('messagerie.typing');
    Route::get('/messagerie/{userId}', [MessagerieController::class, 'show'])->name('messagerie.show');
    Route::delete('/messagerie/{messagerie}', [MessagerieController::class, 'destroy'])->name('messagerie.destroy');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/recent', [NotificationController::class, 'recent'])->name('recent');
        Route::get('/count', [NotificationController::class, 'count'])->name('count');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});
/*
|--------------------------------------------------------------------------
| POSTS, COMMENTS, LIKES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->names([
        'index' => 'post.all',
        'show' => 'post.view',
        'create' => 'post.new',
        'store' => 'post.store',
        'edit' => 'post.edit',
        'update' => 'post.update',
        'destroy' => 'post.delete',
    ]);

    // Comments
    Route::get('/posts/{post}/comments', [CommentController::class, 'getComments'])->name('comments.getComments');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
});

/*
|--------------------------------------------------------------------------
| DONATIONS
|--------------------------------------------------------------------------
*/
Route::prefix('/donations')->name('donations.')->group(function () {
    Route::get('/admin', [DonationController::class, 'adminIndex'])->name('adminIndex');
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::put('/{id}', [DonationController::class, 'update'])->name('update');
    Route::delete('/{id}', [DonationController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| PRODUCTS (linked to events)
|--------------------------------------------------------------------------
*/
Route::prefix('/events/{event}/products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN USERS
|--------------------------------------------------------------------------
*/
Route::prefix('/admin/users')->name('users.')->group(function () {
    Route::get('/all', [UserController::class, 'listUsers'])->name('listUsers');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{id}', [UserController::class, 'showProfile'])->name('showProfile');
    Route::put('/{user}', [UserController::class, 'edit'])->name('edit');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});
