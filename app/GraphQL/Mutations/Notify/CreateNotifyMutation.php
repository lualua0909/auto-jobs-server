<?php

namespace App\GraphQL\Mutations\Notify;

use App\Models\Company;
use App\Models\Notification;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateNotifyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createNotify',
        'description' => 'Notify mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Notification');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'string'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
      
    }
}
