<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Notifications\NewCommentLikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Comment $comment)
    {
        $userId = Auth::id();

        $existingLike = $comment->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            // Delete the like
            $existingLike->delete();
        } else {
            // Create a new like
            $like = $comment->likes()->create([
                'user_id' => $userId,
            ]);

            $comment->user->notify(new NewCommentLikeNotification($like));
        }

        return response()->json([
            'liked' => !$existingLike,
            'count' => $comment->likes->count(),
        ]);
    }


}
