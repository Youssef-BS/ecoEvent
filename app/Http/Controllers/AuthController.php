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
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|string|email|max:100|unique:users',
            'phone'      => 'nullable|string|max:20',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('/')->with('success', 'Inscription réussie, bienvenue !');
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

        return redirect()->intended($redirectTo)->with('success', 'Connexion réussie !');
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
