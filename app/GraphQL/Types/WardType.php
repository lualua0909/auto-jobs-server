<?php

namespace App\GraphQL\Types;

use App\Models\Ward;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WardType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Ward',
        'description' => 'A type of Ward'
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
            'district_id' => [
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }
}