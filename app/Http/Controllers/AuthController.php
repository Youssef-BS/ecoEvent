<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|string|email|max:100|unique:users',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'bio' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]
        );
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('logos', 'public');
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $imagePath,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'bio' => $request->bio,
            'location' => $request->latitude . ',' . $request->longitude,
        ]);
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Inscription réussie, bienvenue !');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                $redirectTo = '/admin';
            } else {
                $redirectTo = '/';
            }

        // Prefer named routes for clarity and resilience
        $redirectTo = $user->role === 'admin' ? route('admin.dashboard') : route('home');
            return redirect()->intended($redirectTo)->with('success', 'Connexion réussie !');

        throw ValidationException::withMessages([
            'email' => __('Les informations de connexion sont incorrectes.'),
        ]);

    }



}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}
