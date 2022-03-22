<?php

namespace App\GraphQL\Types;

use App\Models\District;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DistrictType extends GraphQLType
{
    protected $attributes = [
        'name' => 'District',
        'description' => 'A type of district'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int())
            ],
            'gso_id' => [
                'type' => Type::nonNull(Type::string())
            ],
            'name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'province_id' => [
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }
}