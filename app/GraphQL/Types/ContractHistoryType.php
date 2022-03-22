<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ContractHistoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ContractHistory',
        'description' => 'A type of ContractHistory',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'contract' => [
                'type' => GraphQL::type('Contract'),
            ],
            'job' => [
                'type' => GraphQL::type('Job'),
            ],
            'status' => [
                'type' => GraphQL::type('ContractStatus'),
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
