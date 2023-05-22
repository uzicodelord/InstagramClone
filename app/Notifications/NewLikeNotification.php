<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLikeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $like;

    public function __construct($like)
    {
        $this->like = $like;
    }

    public function via($notifiable)
    {
        if ($notifiable->id === auth()->id()) {
            return [];
        }

        return ['database'];
    }


    public function toDatabase($notifiable) {
        $likeId = $this->like->id;
        $postId = $this->like->post_id;
        $userId = $this->like->user_id;
        $post = Post::find($postId);
        $user = User::find($userId);
        $userName = $user->name;
        $userProfilePicture = $user->profile_picture;
        $postImage = $post->image;
        $message = $userName . ' liked your post ';
        return [
            'like_id' => $likeId,
            'post_id' => $postId,
            'user_id' => $userId,
            'user_profile_picture' => $userProfilePicture,
            'message' => $message,
            'user_name' => $userName,
            'post_image' => $postImage,
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
