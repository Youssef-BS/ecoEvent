<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{

    public function index()
    {
        $sponsors = Sponsor::all();
        return view('sponsors.ListeSponsor', compact('sponsors'));
    }

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


    public function show(Sponsor $sponsor)
    {
        return view('sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        if (!$sponsor->contribution) {
            $sponsor->contribution = null;
        }
        return view('sponsors.create', compact('sponsor'));
    }


    public function update(Request $request, Sponsor $sponsor)
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

        $sponsor->update($data);

        return redirect()->route('sponsors.ListeSponsor')->with('success', 'Sponsor mis à jour avec succès.');
    }


    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('sponsors.ListeSponsor')->with('success', 'Sponsor supprimé avec succès.');
    }
}
