<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $chats = collect();

        if (request('receiver_id')) {
            $chats = Chat::with('sender')->where(function ($query) {
                $query->where('sender_id', auth()->user()->id)
                    ->where('receiver_id', request('receiver_id'));
            })->orWhere(function ($query) {
                $query->where('sender_id', request('receiver_id'))
                    ->where('receiver_id', auth()->user()->id);
            })->get();

            $chats = $chats->map(function ($chat) {
                $chat->sender->profile_picture_url = Storage::url($chat->sender->profile_picture);
                return $chat;
            });
        }

        if (request()->wantsJson()) {
            return response()->json(['chats' => $chats]);
        }
        return view('chats.index', compact('users', 'chats'))->with('receiver_id', request('receiver_id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required',
        ]);

        $message = Chat::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        $receiver = User::find($request->receiver_id);
        $receiver->notify(new NewMessageNotification($message));
        return back();
    }
}
