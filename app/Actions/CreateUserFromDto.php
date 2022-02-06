<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserFromDto
{
    public static function execute($user)
    {
        return User::create([
            'email'    => $user->email,
            'name'     => "{$user->first_name} {$user->last_name}",
            'password' => Hash::make(Str::random(15)),
        ]);
    }
}
