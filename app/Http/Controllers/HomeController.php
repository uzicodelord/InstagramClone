<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $followingIds = auth()->user()->following()->pluck('users.id')->push(auth()->id());
        $posts = Post::whereIn('user_id', $followingIds)->latest()->get();
        $user = auth::user();
        $suggested = User::inRandomOrder()->limit(5)->get();
        return view('home', compact('posts', 'user', 'suggested'));
    }


    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json($users);
    }

}
