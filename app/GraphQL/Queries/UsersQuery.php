<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Auth;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return Auth::user()->hasRole('sylencer');
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function resolve($root, $args)
    {
        return User::all();
    }
}
