<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

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
                'type' => Type::nonNull(Type::int()),
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
            'birth_date' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'street_name' => [
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
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
