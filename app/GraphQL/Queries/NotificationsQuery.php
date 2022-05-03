<?php

namespace App\GraphQL\Queries;

use App\Models\Notification;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class NotificationsQuery extends Query
{
    protected $attributes = [
        'name' => 'notifications',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Notification');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'default' => 6,
            ],
            'page' => [
                'type' => Type::int(),
                'default' => 1,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return Notification::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
