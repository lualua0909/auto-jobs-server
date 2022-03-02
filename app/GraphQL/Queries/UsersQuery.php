<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Auth;
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

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        if (isset($args['id'])) {
            return Auth::id() == $args['id'];
        }

        return true;
    }

    public function type(): Type
    {
        return GraphQL::paginate('User');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return User::where('created_by', Auth::id())
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
