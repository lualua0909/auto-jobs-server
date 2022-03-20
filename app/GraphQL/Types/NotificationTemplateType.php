<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NotificationTemplateType extends GraphQLType
{
    protected $attributes = [
        'name' => 'NotificationTemplate',
        'description' => 'A type of NotificationTemplate',
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
            'content' => [
                'type' => Type::nonNull(Type::string()),
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
