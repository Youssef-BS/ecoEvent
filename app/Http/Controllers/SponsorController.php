<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    // Page d'accueil
    public function home()
    {
        $donations = Donation::orderBy('created_at', 'desc')->take(3)->get();
        $sponsors = Sponsor::all();
        return view('client.index', compact('sponsors', 'donations'));
    }

    // Liste des sponsors
    public function index()
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsors.ListeSponsor', compact('sponsors'));
    }

    // Formulaire pour créer un sponsor
    public function create()
    {
        return view('sponsors.create');
    }

    // Enregistrer un sponsor
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

    // Afficher un sponsor
    public function show(Sponsor $sponsor)
    {
        return view('sponsors.show', compact('sponsor'));
    }

    // Formulaire pour éditer un sponsor
    public function edit(Sponsor $sponsor)
    {
        return view('sponsors.create', compact('sponsor'));
    }

    // Mettre à jour un sponsor
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

    // Supprimer un sponsor
    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        $sponsor->delete();

        return redirect()->route('sponsors.ListeSponsor')->with('success', 'Sponsor supprimé avec succès.');
    }
}
