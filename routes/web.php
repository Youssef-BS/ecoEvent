<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\UserController;

// // CLIENT ROUTES
// Route::get('/', fn() => view('client.index'))->name('home');
Route::get('/', [SponsorController::class, 'home'])->name('home');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/about', fn() => view('client.about'))->name('about');
Route::get('/contact', fn() => view('client.contact'))->name('contact');
Route::get('/donation', fn() => view('client.donation'))->name('donation');
Route::get('/event', fn() => view('client.event'))->name('event');
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
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');


/**************************sponsor */
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.ListeSponsor');


Route::post('/sponsors', [SponsorController::class, 'store'])->name('sponsors.store');


Route::get('/sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
Route::get('/sponsors/{sponsor}', [SponsorController::class, 'show'])->name('sponsors.show');
Route::get('/sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
Route::put('/sponsors/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
Route::delete('/sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');
