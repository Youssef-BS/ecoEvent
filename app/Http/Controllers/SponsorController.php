<?php

namespace App\Http\Controllers;

use App\ContributionType;
use App\Http\Requests\SponsorRequest;
use App\Models\Sponsor;
use App\Models\Donation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SponsorController extends Controller
{

    public function home()
    {
        $donations = Donation::orderBy('created_at', 'desc')->take(3)->get();
        $sponsors = Sponsor::all();
        return view('client.index', compact('sponsors', 'donations'));
    }

    public function index(Request $request)
    {
        $query = Sponsor::query();


        if ($request->filled('name')) {
            $query->where('name', 'like', $request->name . '%');
        }

        if ($request->filled('contributionType') && in_array($request->contributionType, array_column(ContributionType::cases(), 'value'))) {
            $query->where('contribution', $request->contributionType);
        }

        $sponsors = $query->get();

        return view('admin.sponsors.ListeSponsor', compact('sponsors'));
    }



    public function create()
    {
        return view('admin.sponsors.create');
    }


    public function store(SponsorRequest $request)
    {
        $data = $request->validated();


        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Sponsor::create($data);

        return redirect()
            ->route('sponsors.ListeSponsor')
            ->with('success', 'Sponsor créé avec succès.');
    }


    public function show(Sponsor $sponsor)
    {
        return view('admin.sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.create', compact('sponsor'));
    }


    public function update(SponsorRequest $request, Sponsor $sponsor)
    {
        $data = $request->validated();


        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $sponsor->update($data);

        return redirect()
            ->route('sponsors.ListeSponsor')
            ->with('success', 'Sponsor mis à jour avec succès.');
    }


    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        $sponsor->delete();

        return redirect()
            ->route('sponsors.ListeSponsor')
            ->with('success', 'Sponsor supprimé avec succès.');
    }
}
