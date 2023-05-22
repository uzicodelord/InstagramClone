<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:mp4,jpeg,png,jpg|max:60000', // limit video to 60 seconds
            'type' => 'required|string|in:image,video', // ensure either image or video is uploaded
        ]);

        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->caption = $request->input('caption');

        if ($request->input('type') == 'image') {
            $imagePath = $request->file('media')->store('public/images');
            $post->image = $imagePath;
        } else {
            $videoPath = $request->file('media')->store('public/videos');
            $post->video = $videoPath;
        }

        $post->save();

        return redirect('/home')->with('success', 'Post created successfully!');
    }


    public function index()
    {
        $posts = Post::with('user')->inRandomOrder()->simplePaginate(21);
        return view('posts.index', compact('posts'));
    }


    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        $user = $post->user;
        $comments = $post->comments()->with('user')->get();
        return view('posts.show', compact('post', 'user', 'comments'));
    }

    public function edit($postId)
    {
        $post = Post::findOrFail($postId);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $postId)
    {
        $request->validate([
            'caption' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);
        $post->caption = $request->input('caption');

        $post->save();

        return redirect()->route('posts.show', ['postId' => $post->id])->with('success', 'Post updated successfully!');
    }

    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();

        $user = auth::user();
        $posts = Post::with('user')->latest()->get();
        return view('home', compact('posts', 'user'));
    }
}
