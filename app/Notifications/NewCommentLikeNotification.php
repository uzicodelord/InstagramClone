<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentLikeNotification extends Notification
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
        $commentId = $this->like->comment_id;
        $userId = $this->like->user_id;
        $comment = Comment::find($commentId);
        $post = Post::find($comment->post_id);
        $user = User::find($userId);
        $userName = $user->name;
        $userProfilePicture = $user->profile_picture;
        $message = $userName . ' liked your comment on ';
        return [
            'like_id' => $this->like->id,
            'comment_id' => $commentId,
            'user_id' => $userId,
            'post_id' => $post->id,
            'post_image' => $post->image,
            'user_name' => $userName,
            'user_profile_picture' => $userProfilePicture,
            'message' => $message,
        ];
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
