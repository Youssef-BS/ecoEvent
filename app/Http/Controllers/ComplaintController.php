<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::all();
        return view('complaints.index', compact('complaints'));
    }


     public function userComplaints()
    {
        $complaints = Complaint::where('user_id', Auth::id())->get();
        return view('complaints.user', compact('complaints'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        return view('complaints.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $complaint = new Complaint();
        $complaint->type = $validated['type'];
        $complaint->description = $validated['description'];
        $complaint->user_id = Auth::id();
        $complaint->status = 0;
        $complaint->event_id = $request->event_id ?? null;
        $complaint->created_at = now();
        $complaint->severity = $this->calculateSeverity($complaint->type);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('complaints', 'public');
            $complaint->image = $path;
            $complaint->severity +=1;
        }



        $complaint->save();

        return "<script>
            alert('Complaint submitted successfully!');
            window.close();
        </script>";
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update($request->all());
        return redirect()->back()->with('success', 'Complaint updated successfully');
    }


    public function reply(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->reply = $request->input('reply');
        $complaint->status = 1; // Mark as addressed
        $complaint->save();

        return redirect()->back()->with('success', 'Reply sent successfully');
    }
    // Delete complaint
    public function destroy($id)
    {
        Complaint::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Complaint deleted successfully');
    }

    private function calculateSeverity($type)
    {
        switch (strtolower($type)) {

            case 'payment process':return 4;

            case 'event':return 2;

            case 'posting':return 1;

            case 'website':return 4;

            case 'store':return 3;  

            default:return 0;
        }
    }
}
