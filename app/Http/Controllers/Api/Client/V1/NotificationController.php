<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Notifications\ChildRemind;

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

        $this->user()->notify(new ChildRemind($title, $message));
    }
}
