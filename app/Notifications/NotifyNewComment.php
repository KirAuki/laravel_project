<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;

class NotifyNewComment extends Notification
{
    use Queueable;

    protected $article;
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    public function via($notifiable)
    {
        return ['database'];
    }

    
    public function toDatabase($notifiable)
    {
        return [
            'article'=>$this->article,
        ];
    }

   
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}