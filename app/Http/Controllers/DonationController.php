<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $donations = Donation::all();
        
        // Statistics calculations
        $totalCampaigns = Donation::count();
        $totalDonors = Donation::sum('donor_count');
        $totalRaised = Donation::sum('reached');
        $totalGoal = Donation::sum('amount');
        $completedCampaigns = Donation::where('reached', '>=', DB::raw('amount'))->count();
        $activeCampaigns = $totalCampaigns - $completedCampaigns;
        
        return view('client.donation', compact(
            'donations',
            'totalCampaigns',
            'totalDonors',
            'totalRaised',
            'totalGoal',
            'completedCampaigns',
            'activeCampaigns'
        ));
    }
    /**
     * admin index
     *
     */
    public function adminIndex()
    {
        $donations = Donation::with('user')->get();
        return view('donations.adminIndex', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
            'payment_methods' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'user_id' => 'required|exists:users,id'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'donation_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Store image in storage/app/public/donations
            $imagePath = $image->storeAs('donations', $imageName, 'public');
            $validated['image'] = $imageName; // Store only the filename
        }

        Donation::create($validated);

        return redirect()->route('donations.adminIndex')
            ->with('success', 'Donation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

     public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
            'payment_methods' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($donation->image) {
                Storage::disk('public')->delete('donations/' . $donation->image);
            }
            
            $image = $request->file('image');
            $imageName = 'donation_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            $imagePath = $image->storeAs('donations', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        $donation->update($validated);

        return redirect()->route('donations.adminIndex')
            ->with('success', 'Donation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Delete associated image
        if ($donation->image) {
            Storage::disk('public')->delete('donations/' . $donation->image);
        }
        
        $donation->delete();

        return redirect()->route('donations.adminIndex')
            ->with('success', 'Donation deleted successfully');
    }
}
