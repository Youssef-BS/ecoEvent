<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('logos', 'public');
            }


            $location = null;
            if ($request->filled('latitude') && $request->filled('longitude')) {
                $location = $request->latitude . ',' . $request->longitude;
            }

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'image' => $imagePath,
                'bio' => $validated['bio'] ?? null,
                'location' => $location,
                'role' => 'user',
                'password' => Hash::make($validated['password']),
            ]);


            Auth::login($user);

            return redirect()->route('login')
                ->with('success', 'Registration successful! You can now log in.');;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error during registration: ' . $e->getMessage()])
                ->withInput();
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
