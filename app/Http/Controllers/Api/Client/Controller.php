<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    /**
     * @return User
     */
    public function user()
    {
        return $this->request()->user();
    }
}
