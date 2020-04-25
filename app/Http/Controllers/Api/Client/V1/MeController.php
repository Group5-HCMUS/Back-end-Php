<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;
use App\Models\User;

class MeController extends Controller
{
    public function profile()
    {
        return User::with([
            'parent',
            'child',
        ])
            ->whereId($this->user()->id)
            ->firstOrFail();
    }

    public function logout()
    {
        $this->user()->logout();
    }
}
