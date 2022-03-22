<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class NotificationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Notification',
        'description' => 'A type of Notification',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'template' => [
                'type' => GraphQL::type('NotificationTemplate'),
            ],
            'job' => [
                'type' => GraphQL::type('Job'),
            ],
            'company' => [
                'type' => GraphQL::type('Company'),
            ],
            'status' => [
                'type' => Type::int(),
            ],
            'user_id' => [
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
