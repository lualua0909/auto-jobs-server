<?php

namespace App\GraphQL\Queries;

use App\Models\Contract;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ContractsQuery extends Query
{
    protected $attributes = [
        'name' => 'contracts',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Contract');
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
            'condition' => [
                'type' => Type::string(),
                'default' => null,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $query = Contract::where('user_id', auth()->id());
        if (isset($args['condition'])) {
            $condition = explode(",", $args['condition']);

            $query->where($condition[0], $condition[1], $condition[2]);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
