<?php

namespace App\Models;

class ParentModel extends Model
{
    protected $table = 'parents';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(Child::class,'parent_children', 'parent_id', 'child_id')
            ->using(ParentChildren::class)
            ->withTimestamps();
    }
}
