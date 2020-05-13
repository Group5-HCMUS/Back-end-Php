<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

class Child extends Model
{
    use Searchable;

    protected $table = 'children';

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $this->loadMissing([
            'user'
        ]);

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
