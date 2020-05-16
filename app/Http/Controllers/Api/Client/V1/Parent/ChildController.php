<?php

namespace App\Http\Controllers\Api\Client\V1\Parent;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\Child;
use App\Models\ParentChildren;
use Symfony\Component\HttpFoundation\Response;

class ChildController extends Controller
{
    public function connect($id)
    {
        if (!$this->user()->parent) {
            abort(Response::HTTP_FORBIDDEN, 'Parent not found');
        }

        if (Child::whereId($id)->doesntExist()) {
            abort(Response::HTTP_BAD_REQUEST, 'Child does not exists');
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

    public function index()
    {
        if (!$this->user()->parent) {
            abort(Response::HTTP_FORBIDDEN, 'Parent not found');
        }

        $this->validate($this->request(), [
            'limit' => 'integer|min:1|max:50',
        ]);

        $page = $this->request()->get('page', 1);
        $limit = $this->request()->get('limit', 10);
        $sort = $this->request()->get('sort', 'id');
        $dir = $this->request()->get('dir', 'asc');

        $query = Child::whereHas('parent', function ($q) {
            $q->whereParentId($this->user()->parent->id);
        })
            ->with([
                'user',
            ])
            ->orderBy($sort, $dir);

        $totalCount = $query->count();

        return response()
            ->json($query->forPage($page, $limit)->get())
            ->header('X-Total-Count', $totalCount);
    }

    public function get($id)
    {
        if (!$this->user()->parent) {
            abort(Response::HTTP_FORBIDDEN, 'Parent not found');
        }

        return Child::whereHas('parent', function ($q) {
            $q->whereParentId($this->user()->parent->id);
        })
            ->with([
                'user',
            ])
            ->get();
    }
}
