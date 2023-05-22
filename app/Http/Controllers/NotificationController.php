<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications->where('type', '!=', NewMessageNotification::class);

        return view('notifications.index', compact('notifications'));
    }
    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    }
}
