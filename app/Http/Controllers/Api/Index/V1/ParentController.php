<?php

namespace App\Http\Controllers\Api\Index\V1;

use App\Http\Controllers\Controller;
use App\Models\ParentChildren;
use Illuminate\Http\Response;

class ParentController extends Controller
{
    public function getByChild()
    {
        $this->validate($this->request(), [
            'child_id' => 'required|exists:users,id',
        ]);

        $childId = $this->request()->get('child_id');

        $parent = ParentChildren::whereChildId($childId)
            ->get();

        if (empty($parent)) {
            abort(Response::HTTP_BAD_REQUEST, 'Parent not found');
        }

        return $parent;
    }
}
