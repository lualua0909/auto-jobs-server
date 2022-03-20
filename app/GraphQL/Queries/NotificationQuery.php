<?php

namespace App\GraphQL\Queries;

use App\Models\Notification;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class NotificationQuery extends Query
{
    protected $attributes = [
        'name' => 'notification',
    ];

    public function type(): Type
    {
        return GraphQL::type('Notification');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $notification = Notification::findOrFail($args['id']);
        return auth()->id() === $notification->user_id ? $notification : null;
    }
}
