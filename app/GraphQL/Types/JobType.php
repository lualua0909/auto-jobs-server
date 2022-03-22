<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JobType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Job',
        'description' => 'A type of Job',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'type' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'number_of_workers' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'monthly_salary' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'hourly_salary' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'requirements' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'benefits' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'street_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'start_time' => [
                'type' => Type::string(),
            ],
            'end_time' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'created_by' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'ward' => [
                'type' => GraphQL::type('Ward'),
            ],
            'district' => [
                'type' => GraphQL::type('District'),
            ],
            'province' => [
                'type' => GraphQL::type('Province'),
            ],
            'company' => [
                'type' => GraphQL::type('Company'),
            ],
            'degreeRequired' => [
                'type' => GraphQL::type('DegreeCertificate'),
            ],
            'contracts' => [
                'type' => Type::listOf(GraphQL::type('Contract')),
            ],
            'status' => [
                'type' => Type::string(),
            ],
        ];

    }
}
