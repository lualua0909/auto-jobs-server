<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Contract;

use App\Models\Contract;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteContractMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteContract',
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
        $category = Contract::findOrFail($args['id']);
        return $category->delete();
    }
}
