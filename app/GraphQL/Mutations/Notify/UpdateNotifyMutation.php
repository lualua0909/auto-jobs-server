<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Notify;

use App\Models\Notification;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateNotifyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateNotify',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Notification');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return $notify;
    }
}
