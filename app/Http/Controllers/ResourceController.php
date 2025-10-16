<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    // Afficher la liste des ressource
    public function index()
    {
        $resource = Resource::with('sponsor')->get();
        return view('admin.resource.index', compact('resource'));
    }

    // Formulaire pour créer une nouvelle ressource
    public function create()
    {
        $sponsors = Sponsor::all();
        return view('admin.resource.form', compact('sponsors'));
    }

    // Enregistrer la nouvelle ressource
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'sponsor_id' => 'required|exists:sponsors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('resource', 'public');
        }

        Resource::create($data);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
    }

    // Formulaire pour éditer une ressource existante
    public function edit(Resource $resource)
    {
        $sponsors = Sponsor::all();
        return view('resource.form', compact('resource', 'sponsors'));
    }

    // Mettre à jour la ressource
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'sponsor_id' => 'required|exists:sponsors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('resource', 'public');
        }

        $resource->update($data);

        return redirect()->route('resources.index')->with('success', 'Resource updated successfully.');
    }

    // Supprimer une ressource
    public function destroy(Resource $resource)
    {
        if ($resource->image) {
            Storage::disk('public')->delete($resource->image);
        }

        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully.');
    }

    // Afficher les détails d’une ressource (optionnel)
    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }
}
