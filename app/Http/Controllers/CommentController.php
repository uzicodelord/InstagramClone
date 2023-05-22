<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->save();

        $post->user->notify(new NewCommentNotification($comment));


        return response()->json([
            'success' => true,
            'comment' => $comment,
            'user' => [
                'name' => $comment->user->name,
                'profile_picture' => Storage::url($comment->user->profile_picture),
            ],
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }
}
