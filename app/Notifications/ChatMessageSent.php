<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ChatMessageSent extends Notification implements ShouldQueue
{
    use Queueable;

    const EVENT_NAME = 'chat_message_sent';

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $message;

    /**
     * @param $sender
     * @param $message
     */
    public function __construct($sender, $message)
    {
        $this->sender = $sender;
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
            'title' => $this->sender,
            'body' => $this->message,
        ];

        $message->content($content)
            ->data([
                'type' => self::EVENT_NAME,
            ]);

        return $message;
    }
}
