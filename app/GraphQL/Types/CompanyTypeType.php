<?php

namespace App\GraphQL\Types;

use App\Models\CompanyType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CompanyTypeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CompanyType',
        'description' => 'A type of CompanyType'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int())
            ],
            'name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string())
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }
}