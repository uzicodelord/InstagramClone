<?php

namespace App\Http\Livewire;

use App\Notifications\NewMessageNotification;
use Livewire\Component;

class Notifications extends Component
{
    public function getUnreadCountProperty()
    {
        return auth()->user()->unreadNotifications->where('type', '!=', NewMessageNotification::class)->count();
    }

    public function getNotificationsProperty()
    {
        return auth()->user()->notifications->where('type', '!=', NewMessageNotification::class);
    }
    public function markAllNotificationsAsRead() {
        auth()->user()->unreadNotifications->where('type', '!=', NewMessageNotification::class)->markAsRead();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
