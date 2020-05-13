<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ParentChildren extends Pivot
{
    protected $table = 'parent_children';
}
