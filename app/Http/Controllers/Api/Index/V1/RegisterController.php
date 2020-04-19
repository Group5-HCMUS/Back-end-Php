<?php

namespace App\Http\Controllers\Api\Index\V1;

use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        $messages = [
            'email.unique' => 'The email address is already used. Use Retrieve Account link to get your details',
        ];

        $this->validate($this->request(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], $messages);

        $email = $this->request()->get('email');
        $password = $this->request()->get('password');
        $fullName = $this->request()->get('full_name');


        $user = new User();
        $user->email = $email;
        $user->password = app('hash')->make($password);
        $user->full_name = trim($fullName);
        $user->save();

        return $user;
    }
}
