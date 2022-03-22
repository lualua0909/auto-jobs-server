<?php

namespace App\GraphQL\Queries;

use App\Models\Province;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ProvincesQuery extends Query
{
    protected $attributes = [
        'name' => 'provinces',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Province'));
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return Province::all();
    }
}
