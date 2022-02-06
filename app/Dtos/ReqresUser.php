<?php

namespace App\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class ReqresUser extends DataTransferObject
{
    public int $id;
    public string $email;
    public string $first_name;
    public string $last_name;
    public string $avatar;
}
