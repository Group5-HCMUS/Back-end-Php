<?php

namespace App\Http\Controllers\Api\Client\V1\Child;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\Child;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function create()
    {
        if ($this->user()->child) {
            abort(Response::HTTP_BAD_REQUEST, 'Child has exists');
        }
        if ($this->user()->parent) {
            abort(Response::HTTP_BAD_REQUEST, 'Can not create child on parent account');
        }

        $child = new Child();
        $child->user()->associate($this->user()->id);
        $child->save();

        return $child;
    }
}
