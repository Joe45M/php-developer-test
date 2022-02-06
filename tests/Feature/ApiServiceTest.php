<?php

namespace Tests\Feature;

use App\Dtos\ReqresUser;
use App\Services\ReqresApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{

    public function test_api_returns_200_status()
    {
        $service = new ReqresApiService();

        $response = $service->users(returnResponse: true);

        $this->assertEquals(200, $response->getStatusCode());

    }

    public function test_api_returns_collection_by_default()
    {
        $service = new ReqresApiService();

        $response = $service->users();

        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_api_returns_response_when_flag_is_provided()
    {
        $service = new ReqresApiService();

        $response = $service->users(returnResponse: true);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function test_api_collection_contains_dtos()
    {
        $service = new ReqresApiService();

        $response = $service->users();

        $this->assertInstanceOf(ReqresUser::class, $response->first());
    }
}
