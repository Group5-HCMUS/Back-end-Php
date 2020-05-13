<?php

namespace App\Http\Controllers\Api\Client\V1\Parent;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\ParentChildren;
use Symfony\Component\HttpFoundation\Response;

class ChildController extends Controller
{
    public function connect($id)
    {
        if (!$this->user()->parent) {
            abort(Response::HTTP_FORBIDDEN, 'Parent not found');
        }

        $parentChildren = ParentChildren::whereChildId($id)
            ->whereParentId($this->user()->parent->id)
            ->first();

        if (empty($parentChildren)) {
            $parentChildren = new ParentChildren();
            $parentChildren->child_id = $id;
            $parentChildren->parent_id = $this->user()->parent->id;
            $parentChildren->save();
        }

        return $parentChildren;
    }
}
