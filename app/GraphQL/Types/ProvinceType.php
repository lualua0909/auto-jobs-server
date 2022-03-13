<?php

namespace App\GraphQL\Types;

use App\Models\Province;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProvinceType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Province',
        'description' => 'A type of province'
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
            ]
        ];
    }
}