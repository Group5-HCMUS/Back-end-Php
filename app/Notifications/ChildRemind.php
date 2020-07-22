<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ChildRemind extends Notification implements ShouldQueue
{
    use Queueable;

    const EVENT_NAME = 'child_remind';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $message;

    /**
     * @param $title
     * @param $message
     */
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * @param mixed $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return [
            'fcm',
        ];
    }

    /**
     * @param mixed $notifiable
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        $message = new FcmMessage();

        $content = [
            'title' => $this->title,
            'body' => $this->message,
        ];

        $message->content($content)
            ->data([
                'type' => self::EVENT_NAME,
            ]);

        return $message;
    }
}
