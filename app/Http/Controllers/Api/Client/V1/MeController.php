<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Api\Client\Controller;

class MeController extends Controller
{
    public function profile()
    {
        return $this->user();
    }

    public function logout()
    {
        $this->user()->logout();
    }
}
