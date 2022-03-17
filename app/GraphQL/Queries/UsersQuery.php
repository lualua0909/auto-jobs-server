<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('User');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'default' => 4,
            ],
            'page' => [
                'type' => Type::int(),
                'default' => 1,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return User::paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
