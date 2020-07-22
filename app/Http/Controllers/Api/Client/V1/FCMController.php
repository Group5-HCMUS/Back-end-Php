<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\FCMToken;
use Symfony\Component\HttpFoundation\Response;

class FCMController extends Controller
{
    public function register()
    {
        $token = $this->request()->get('token');

        $this->validate($this->request(), [
            'token' => 'required',
        ]);

        if (empty($this->user()->id)) {
            abort(Response::HTTP_BAD_REQUEST, 'Invalid user');
        }

        if (FCMToken::whereToken($token)
            ->whereUserId($this->user()->id)
            ->exists()
        ) {
            abort(Response::HTTP_BAD_REQUEST, 'Token was registered by this user');
        }

        FCMToken::whereToken($token)->delete();

        $fcmToken = new FCMToken();
        $fcmToken->user()->associate($this->user()->id);
        $fcmToken->token = $token;
        $fcmToken->save();
    }

    public function unregister()
    {
        $token = $this->request()->get('token');

        $this->validate($this->request(), [
            'token' => 'required',
        ]);

        if (empty($this->user()->id)) {
            abort(Response::HTTP_BAD_REQUEST, 'Invalid user');
        }

        FCMToken::whereToken($token)
            ->whereUserId($this->user()->id)
            ->delete();
    }
}
