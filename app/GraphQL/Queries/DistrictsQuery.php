<?php

namespace App\GraphQL\Queries;

use App\Models\District;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class DistrictsQuery extends Query
{
    protected $attributes = [
        'name' => 'districts',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('District'));
    }

    public function args(): array
    {
        return [
            'province_id' => [
                'name' => 'province_id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $province_id = $args['province_id'] ?? null;

        return $province_id ? District::where('province_id', $province_id)->get() : District::all();
    }
}
