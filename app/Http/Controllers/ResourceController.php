<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{

    public function index(Request $request)
    {
        $query = Resource::with('sponsor');

        if ($request->filled('title')) {
            $query->where('title', 'like', $request->title . '%');
        }

        if ($request->filled('quantity')) {
            $query->where('quantity', '>=', $request->quantity);
        }

        $resource = $query->get();

        return view('admin.resource.index', compact('resource'));
    }



    public function create()
    {
        $sponsors = Sponsor::all();
        return view('admin.resource.form', compact('sponsors'));
    }


    public function store(Request $request)
    {
        $data = $request->only(['title', 'quantity', 'sponsor_id']);

        if (!$request->hasFile('image')) {
            return back()->withErrors(['image' => 'Image file is required.'])->withInput();
        }

        $imageFile = $request->file('image');

        // --- Appel à l'API Flask pour validation ---
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post('http://127.0.0.1:5001/validate-resource', [
                'multipart' => [
                    [
                        'name' => 'resource',
                        'contents' => json_encode($data)
                    ],
                    [
                        'name' => 'image',
                        'contents' => fopen($imageFile->getPathname(), 'r'),
                        'filename' => $imageFile->getClientOriginalName()
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (!isset($result['status']) || $result['status'] !== 'ok') {
                return back()->withErrors($result['messages'] ?? ['Unknown validation error'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Validation service unavailable: ' . $e->getMessage()])->withInput();
        }


        $data['image'] = $imageFile->store('resource', 'public');


        Resource::create($data);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
    }


    public function edit(Resource $resource)
    {
        $sponsors = Sponsor::all();
        return view('admin.resource.form', compact('resource', 'sponsors'));
    }


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

    public function destroy(Resource $resource)
    {
        if ($resource->image) {
            Storage::disk('public')->delete($resource->image);
        }

        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully.');
    }


    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }
}
