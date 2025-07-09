<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function indexPosts()
    {
        $posts = Post::with('comments.user')->latest()->paginate(4);
        return view('posts.index', compact('posts'));
    }

    // public function show(Post $post)
    // {
    //     $post->load('comments.user');
    //     return view('posts.show', compact('post'));
    // }
    public function show(Post $post)
{
    $comments = $post->comments()->with('user')->latest()->paginate(10);
    return view('posts.show', compact('post', 'comments'));
}

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added!');
    }
}

