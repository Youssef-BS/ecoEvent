<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FaceLoginController extends Controller
{
    public function loginWithFace()
    {
        $response = Http::get('http://127.0.0.1:5010/recognize_face');

        if ($response->ok()) {
            $data = $response->json();

            if (isset($data['username'])) {
                $user = User::where('first_name', explode(' ', $data['username'])[0])
                    ->where('last_name', explode(' ', $data['username'])[1])
                    ->first();

                if ($user) {
                    Auth::login($user);
                    return redirect('/');
                }
            }

            return redirect()->route('login')->with('error', $data['message'] ?? 'Visage non reconnu');
        }

        return redirect()->route('login')->with('error', 'Erreur de communication avec le service de reconnaissance faciale');
    }
}
