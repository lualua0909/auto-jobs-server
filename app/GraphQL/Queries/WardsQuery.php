<?php

namespace App\GraphQL\Queries;

use App\Models\Ward;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class WardsQuery extends Query
{
    protected $attributes = [
        'name' => 'wards',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Ward'));
    }

    public function args(): array
    {
        return [
            'district_id' => [
                'name' => 'district_id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $district_id = $args['district_id'] ?? null;

        return $district_id ? Ward::where('district_id', $district_id)->get() : Ward::all();
    }
}
