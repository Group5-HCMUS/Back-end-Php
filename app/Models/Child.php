<?php

namespace App\Models;

class Child extends Model
{
    protected $table = 'children';

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
    public function parent()
    {
        return $this->belongsToMany(ParentModel::class, 'parent_children', 'child_id', 'parent_id')
            ->using(ParentChildren::class)
            ->withTimestamps();
    }
}
