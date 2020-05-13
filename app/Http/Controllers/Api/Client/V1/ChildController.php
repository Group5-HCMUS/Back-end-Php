<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\Child;

class ChildController extends Controller
{
    public function index()
    {
        $this->validate($this->request(), [
            'limit' => 'integer|min:1|max:50',
        ]);

        $page = $this->request()->get('page', 1);
        $limit = $this->request()->get('limit', 10);
        $sort = $this->request()->get('sort', 'id');
        $dir = $this->request()->get('dir', 'asc');

        $search = $this->request()->get('q');

        $query = Child::query()
            ->withCount([
                'availablePockets',
                'pockets',
            ]);

        if ($search) {
            $searchResultIds = Child::search($search)->keys()->toArray();
            $query->whereIn('id', $searchResultIds)
                ->orderByRaw('ARRAY_POSITION(ARRAY[' . implode(',', $searchResultIds) . ']::BIGINT[], id) ASC');
        } else {
            $query->orderBy($sort, $dir);
        }

        $totalCount = $query->count();

        return response()
            ->json($query->forPage($page, $limit)->get())
            ->header('X-Total-Count', $totalCount);
    }

    public function get($id)
    {
        return Child::whereId($id)
            ->firstOrFail();
    }
}
