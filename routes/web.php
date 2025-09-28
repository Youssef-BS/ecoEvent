<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/donation', function () {
    return view('donation');
})->name('donation');

Route::get('/event', function () {
    return view('event');
})->name('event');

Route::get('/feature', function () {
    return view('feature');
})->name('feature');

Route::get('/service', function () {
    return view('service');
})->name('service');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/testimonial', function () {
    return view('testimonial');
})->name('testimonial');

Route::resource('users', UserController::class);
