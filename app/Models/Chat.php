<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

class Chat extends Model
{
    use Searchable;

    protected $table = 'chats';

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        return Arr::only(Arr::dot($this->toArray()), [
            'id',
            'user.full_name',
            'user.email',
            'user.phone_number',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
