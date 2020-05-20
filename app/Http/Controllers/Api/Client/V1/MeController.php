<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Enums\Gender;
use App\Http\Controllers\Api\Client\Controller;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;

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

    public function update()
    {
        $this->validate($this->request(), [
            'full_name' => 'string',
            'gender' => [
                new EnumValue(Gender::class),
            ],
            'birth_date' => 'date',
        ]);

        $user = $this->user();
        $user->fill($this->request()->all());
        $user->save();

        return $user;
    }

    public function logout()
    {
        $this->user()->logout();
    }
}
