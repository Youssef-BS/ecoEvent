<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{



    public function create()
    {
        return view('sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contribution' => 'required|in:financial,material,logistical',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Sponsor::create($data);

        return redirect()->route('sponsors.ListeSponsor')->with('success', 'Sponsor créé avec succès.');
    }
}
