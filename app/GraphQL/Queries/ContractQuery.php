<?php

namespace App\GraphQL\Queries;

use App\Models\Contract;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ContractQuery extends Query
{
    protected $attributes = [
        'name' => 'contract',
    ];

    public function type(): Type
    {
        return GraphQL::type('Contract');
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
        $contract = Contract::findOrFail($args['id']);
        return $contract->user_id === auth()->id() ? $contract : null;
    }
}
