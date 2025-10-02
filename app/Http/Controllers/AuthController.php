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
        try {
            $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|string|email|max:100|unique:users',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'bio' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('logos', 'public');
            }

            $location = null;
            if ($request->filled('latitude') && $request->filled('longitude')) {
                $location = $request->latitude . ',' . $request->longitude;
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $imagePath,
                'password' => Hash::make($request->password),
                'role' => 'user', // ← Définition explicite du rôle
                'bio' => $request->bio,
                'location' => $location,
            ]);

            Auth::login($user);
            return redirect()->route('home')->with('success', 'Inscription réussie, bienvenue !');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérification sécurisée du rôle
            if (!$user) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => __('Erreur lors de la récupération de l\'utilisateur.'),
                ]);
            }

            // Vérifiez que l'utilisateur a bien un rôle
            $userRole = $user->role ?? 'user'; // Valeur par défaut si le rôle n'existe pas

            // Redirection basée sur le rôle
            if ($userRole === 'admin') {
                return redirect()->intended('/admin')->with('success', 'Connexion réussie !');
            } else {
                return redirect()->intended('/')->with('success', 'Connexion réussie !');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('Les informations de connexion sont incorrectes.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}
