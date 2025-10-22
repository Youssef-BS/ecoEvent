<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
     /**
     * Toggle like/unlike for a post.
     */
    public function toggle(Post $post)
    {
        $existingLike = $post->likes()
            ->where('user_id', Auth::id())
            ->first();
    
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
        } else {
            // Like
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,   // ✅ Add this line
                'reaction' => 'like',
            ]);
        }
    
        return back();
    }
    


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
