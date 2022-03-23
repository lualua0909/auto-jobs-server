<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class JobSavedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JobSaved',
        'description' => 'A type of JobSaved',
    ];

    public function fields(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'job_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'user' => [
                'type' => GraphQL::type('User'),
            ],
            'job' => [
                'type' => GraphQL::type('Job'),
            ],
        ];
    }
}
