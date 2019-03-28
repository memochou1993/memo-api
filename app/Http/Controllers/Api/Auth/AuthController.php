<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use GuzzleHttp\Exception\ClientException;

class AuthController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        try {
            $client = new Client([
                'base_uri' => config('app.url'),
            ]);

            $response = $client->post('/api/users', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $this->request->all(),
            ]);

            return response($response->getBody(), 200);
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        try {
            $client = new Client([
                'base_uri' => config('app.url'),
            ]);

            $response = $client->post('/oauth/token', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $this->request->all(),
            ]);

            return response($response->getBody(), 200);
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->auth('api')->user()->token()->revoke();

        return response(null, 204);
    }

    /**
     * @return \App\User
     */
    public function user()
    {
        $user = $this->auth('api')->user();

        return new UserResource($user);
    }
}
