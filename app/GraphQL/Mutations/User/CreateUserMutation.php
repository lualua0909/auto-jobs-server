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
                'rules' => ['required'],
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email', 'unique:users'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = new User();
        $user->fill($args);
        $user->save();

        return $user;
    }
}
