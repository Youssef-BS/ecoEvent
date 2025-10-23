<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function getComments(Post $post, Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 2);
        
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user' => [
                        'first_name' => $comment->user->first_name,
                    ],
                    'time_ago' => $comment->created_at->diffForHumans(),
                    'can_edit' => $comment->user_id == Auth::id(), // Add this line
                ];
            });
            
        return response()->json($comments);
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
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

         // Get post + owner
            $post = $comment->post;
            $owner = $post->user;
            $commenter = Auth::user();
            
            // Send data to n8n webhook
            Http::post('http://localhost:5678/webhook-test/new_comment', [
                'post_id' => $post->id,
                'comment_content' => $comment->content,
                'commenter_name' => $commenter->first_name,
                'post_owner_name' => $owner->first_name,
                'post_owner_email' => $owner->email,
            ]);



        return back()->with('success', 'Comment added successfully!');
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
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->only(['content']));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Ensure user owns the comment or is an admin
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
