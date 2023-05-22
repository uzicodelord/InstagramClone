<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(User $user)
    {
        Auth::user()->following()->attach($user->id);

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        Auth::user()->following()->detach($user->id);

        return redirect()->back();
    }
}
