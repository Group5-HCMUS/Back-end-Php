<?php

namespace App\Http\Controllers\Api\Client\V1\Parent;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\ParentModel;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function create()
    {
        if ($this->user()->parent) {
            abort(Response::HTTP_BAD_REQUEST, 'Parent has exists');
        }
        if ($this->user()->child) {
            abort(Response::HTTP_BAD_REQUEST, 'Can not create parent on child account');
        }

        $parent = new ParentModel();
        $parent->user()->associate($this->user()->id);
        $parent->save();

        return $parent;
    }
}
