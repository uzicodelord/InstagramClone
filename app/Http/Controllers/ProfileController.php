<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        $followings = $user->following()->with('followers')->get();
        $followers = $user->followers()->with('following')->get();
        return view('profiles.show', ['user' => $user],compact('followers', 'followings'));
    }

    public function edit($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->bio = $validatedData['bio'];

        if ($request->hasFile('profile_picture')) {
            $oldProfilePicture = $user->profile_picture;

            if ($oldProfilePicture !== 'profile_picture/default.png') {
                Storage::disk('public')->delete($oldProfilePicture);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_picture', 'public');

            // If the uploaded file is the default.png file, don't delete it
            if ($profilePicturePath === 'profile_picture/default.png') {
                $user->profile_picture = $profilePicturePath;
            } else {
                $user->profile_picture = $profilePicturePath;
            }
        }
        $user->is_private = $request->has('is_private');
        $user->save();

        return redirect()->route('profiles.show', $user->name);
    }

        public function follow(User $user)
    {
        auth()->user()->follow($user);
        return back();
    }

    public function unfollow(User $user)
    {
        auth()->user()->unfollow($user);
        return back();
    }

    public function search(Request $request)
    {
        $search = $request->input('query');
        $users = User::where('name', 'LIKE', '%' . $search . '%')->get();
        return response()->json($users);
    }
}
