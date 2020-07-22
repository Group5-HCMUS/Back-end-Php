<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Notifications\ChatMessageSent;
use http\Message;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function sendMessage()
    {
        $this->validate($this->request(), [
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $message = $this->request()->get('message');
        $receiverId = $this->request()->get('receiver_id');

        if ($this->user()->id == $receiverId) {
            abort(Response::HTTP_BAD_REQUEST, 'Can not send for yours');
        }

        $chat = new Chat();
        $chat->sender()->associate($this->user());
        $chat->receiver()->associate($receiverId);
        $chat->status = 'Unread';
        $chat->message = $message;

        $status = $chat->save();

        if ($status) {
            $receiver = User::whereId($receiverId)
                ->first();
            $receiver->notify(new ChatMessageSent($this->user()->full_name, $message));
        }

        return response()
            ->json($status);
    }

    public function messages()
    {
        $this->validate($this->request(), [
            'limit' => 'integer|min:1|max:50',
            'receiver_id' => 'exists:users,id',
        ]);

        $page = $this->request()->get('page', 1);
        $limit = $this->request()->get('limit', 10);
        $sort = $this->request()->get('sort', 'id');
        $dir = $this->request()->get('dir', 'asc');

        $receiverId = $this->request()->get('receiver_id');

        $query = Chat::query()
            ->orderBy($sort, $dir);

        if ($receiverId) {
            $query->whereReceiverId($receiverId);
        }

        $totalCount = $query->count();

        return response()
            ->json($query->forPage($page, $limit)->get())
            ->header('X-Total-Count', $totalCount);
    }
}
