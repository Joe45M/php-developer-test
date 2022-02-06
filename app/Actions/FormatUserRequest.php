<?php

namespace App\Actions;

use App\Dtos\ReqresUser;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class FormatUserRequest
{
    /**
     * @param  Response  $response
     *
     * @return Collection
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function execute(Response $response): Collection
    {
        $formattedUsers = collect();

        $response = $response->collect();

        if (!$response->has('data')) {
            return $formattedUsers;
        }

        foreach ($response->get('data') as $apiUser) {
            $userDto = new ReqresUser($apiUser);
            $formattedUsers->push($userDto);
        }

        return $formattedUsers;
    }
}
