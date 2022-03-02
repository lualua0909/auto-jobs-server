<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'User',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }
    
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        return auth()->id() === $user->created_by ? $user : null;
    }
}
