<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type of user',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'gender' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'total_rating' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'hourly_salary' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'birth_date' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'role' => [
                'type' => Type::string(),
            ],
            'street_name' => [
                'type' => Type::string(),
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
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'job_saved' => [
                'type' => Type::listOf(GraphQL::type('Job')),
            ],
            'lat' => [
                'type' => Type::float(),
            ],
            'long' => [
                'type' => Type::float(),
            ],
            'lat_delta' => [
                'type' => Type::float(),
            ],
            'long_delta' => [
                'type' => Type::float(),
            ],
            'fcm_token' => [
                'type' => Type::string(),
            ],
        ];
    }
}
