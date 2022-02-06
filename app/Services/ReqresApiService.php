<?php

namespace App\Services;

use App\Actions\FormatUserRequest;
use App\Dtos\ReqresUser;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ReqresApiService
{
    private $client;

    private $previousRequest;

    public function __construct(private string|null $baseUrl = null)
    {
        if ( ! $this->baseUrl) {
            $this->baseUrl = config('services.reqres.base');
        }

        $this->client = Http::baseUrl($this->baseUrl);

        return $this;
    }

    /**
     * Get a list of users from the API.
     *
     * @param  bool  $returnResponse
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function users($returnResponse = false): Collection|Response
    {
        $response = $this->client->get('users');

        if ($response->status() !== 200) {
            throw new Exception("Error fetching users, status code {$response->status()}");
        }


        if ($returnResponse) {
            return $response;
        }

        $this->set_previous_request($response);

        return FormatUserRequest::execute($response);
    }

    /**
     * @return mixed
     */
    public function previousRequest()
    {
        return $this->previousRequest;
    }

    /**
     * @param  mixed  $previousRequest
     *
     * @return ReqresApiService
     */
    public function set_previous_request($previousRequest)
    {
        $this->previousRequest = $previousRequest;

        return $this;
    }


}
