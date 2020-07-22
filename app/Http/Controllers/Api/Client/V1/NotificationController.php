<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\FCMToken;
use App\Notifications\ChildRemind;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function send()
    {
        $this->validate($this->request(), [
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $title = $this->request()->get('title');
        $message = $this->request()->get('message');

        $fcmToken = FCMToken::whereUserId($this->user()->id)
            ->first();

        if (empty($fcmToken)) {
            abort(Response::HTTP_BAD_REQUEST, "Not found fcm token of user");
        }

        $this->user()->notifyNow(new ChildRemind($title, $message));
    }
}
