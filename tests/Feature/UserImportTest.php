<?php

namespace Tests\Feature;

use App\Actions\CreateUserFromDto;
use App\Actions\ValidateReqresDto;
use App\Dtos\ReqresUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validator_rejects_duplicates()
    {
        $user = new ReqresUser([
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'avatar' => 'https://http.cat/404'
        ]);

        CreateUserFromDto::execute($user);

        // Validating the same user after it's created should fail, as it will contain a dupe email.

        $validator = ValidateReqresDto::execute($user);
        $errors = $validator->errors();

        $this->assertTrue($errors->isNotEmpty());

    }
}
