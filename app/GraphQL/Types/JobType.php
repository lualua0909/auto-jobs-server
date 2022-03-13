<?php

namespace App\GraphQL\Types;

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
            'company_id' => [
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
            'degree_required_id' => [
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
            'ward_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'district_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'province_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'start_time' => [
                'type' => Type::nonNull(Type::string()),
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
        ];
    }
}
