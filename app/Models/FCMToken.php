<?php

namespace App\Models;

class FCMToken extends Model
{
    protected $table = 'fcm_tokens';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
