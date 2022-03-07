<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
        'description' => 'User mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'string'],
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email', 'unique:users', 'max:255'],
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'unique:users'],
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'min:6'],
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $args['password'] = bcrypt($args['password']);
        $user = User::create($args);
        if (!$user) {
            return null;
        }

        return $user;
    }
}
