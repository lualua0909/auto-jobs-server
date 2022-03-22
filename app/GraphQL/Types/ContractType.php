<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ContractType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Contract',
        'description' => 'A type of Contract',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
            'job_id' => [
                'type' => Type::int(),
            ],
            'user_id' => [
                'type' => Type::int(),
            ],
            'employer_id' => [
                'type' => Type::int(),
            ],
            'user' => [
                'type' => GraphQL::type('User'),
            ],
            'employer' => [
                'type' => GraphQL::type('User'),
            ],
            'job' => [
                'type' => GraphQL::type('Job'),
            ],
            'status' => [
                'type' => Type::string(),
            ],
            'finished_at' => [
                'type' => Type::string(),
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
