<?php

namespace App\Actions;

use App\Dtos\ReqresUser;
use Validator;

class ValidateReqresDto
{
    public static function execute(ReqresUser $user) {
        return Validator::make($user->toArray(), [
            'id' => 'required|integer',
            'email' => 'required|unique:users|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
    }
}
