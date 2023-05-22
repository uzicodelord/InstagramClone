<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Notifications\NewLikeNotification;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($postId)
    {
        $post = Post::find($postId);
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();

            $count = $post->likes()->count();
            return response()->json(['liked' => false, 'count' => $count]);
        } else {
            $like = new Like();
            $like->post_id = $post->id;
            $like->user_id = $user->id;
            $like->save();
            $post->user->notify(new NewLikeNotification($like));
            $count = $post->likes()->count();
            return response()->json(['liked' => true, 'count' => $count]);
        }
    }

}
