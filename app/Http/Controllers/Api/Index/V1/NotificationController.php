<?php

namespace App\Http\Controllers\Api\Index\V1;

use App\Http\Controllers\Controller;
use App\Models\FCMToken;
use App\Notifications\ChildRemind;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function send()
    {
        $this->validate($this->request(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $userId = $this->request()->get('user_id');
        $title = $this->request()->get('title');
        $message = $this->request()->get('message');

        $tokens = FCMToken::query()
            ->whereUserId($userId)
            ->pluck('token')
            ->toArray();

        if (!empty($tokens)) {
            Notification::route('fcm', $tokens)
                ->notify(new ChildRemind($title, $message));
        }
    }
}
