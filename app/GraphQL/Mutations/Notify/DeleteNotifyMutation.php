<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Notify;

use App\Models\Notification;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteNotifyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteNotify',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return Type::boolean();
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
        $notify = Notification::findOrFail($args['id']);
        return $notify->user_id === auth()->id() ? $notify->delete() : null;
    }
}
