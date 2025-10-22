<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.post', ['posts' => $posts]);
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
            'content' => 'required|string|max:1000',
            // media is the value of input tag in name property
            'media'   => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,ogg|max:10240', // 10MB
        ]);
    
        $path = null;
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('posts', 'public');
        }
    
       
        Auth::user()->posts()->create([
            'content'   => $validated['content'],
            'media_url' => $path,
            'user_id'   => Auth::id(), // assumes posts belong to users
        ]);
    
        return redirect()->route('post.all')->with('success', 'Post created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.editPost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
            // Validate
            $validated = $request->validate([
                'content' => 'required|string|max:255',
            ]);
        
            $post->update($validated);
        
            if ($request->hasFile('media')) {
                $path = $request->file('media')->store('posts', 'public');
                $post->media_url = $path;
                $post->save();
            }
    
        return redirect()->route('post.all')->with('success', 'Post edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        // Redirect to a named route after deleting a post
        return redirect()->route('post.all')->with('success', 'Post deleted!');

    }
}
