<?php

namespace App\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Rebing\GraphQL\Support\Mutation;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return Type::listOf(Type::string());
    }

    public function args(): array
    {
        return [
            'username' => ['name' => 'username', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
        $credentials = [
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'grant_type' => 'password',
            'username' => $args['username'],
            'password' => $args['password'],
        ];

        $token = $this->makeRequest($credentials);

        return $token;
    }

    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['message']);
        }
        return $decodedResponse;
    }
}
