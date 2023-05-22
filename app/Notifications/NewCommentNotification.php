<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        if ($notifiable->id === auth()->id()) {
            return [];
        }

        return ['database'];
    }


    public function toDatabase($notifiable): array {
        $commentId = $this->comment->id;
        $postId = $this->comment->post_id;
        $userId = $this->comment->user_id;
        $content = $this->comment->content;
        $post = Post::find($postId);
        $user = User::find($userId);
        $userName = $user->name;
        $userProfilePicture = $user->profile_picture;
        $message = $userName . ' commented on your post ';
        return [
            'comment_id' => $commentId,
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content,
            'user_name' => $userName,
            'user_profile_picture' => $userProfilePicture,
            'message' => $message,
            'post_image' => $post->image,
        ];
    }

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
