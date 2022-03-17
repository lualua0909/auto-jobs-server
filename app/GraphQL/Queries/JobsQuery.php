<?php

namespace App\GraphQL\Queries;

use App\Models\Job;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class JobsQuery extends Query
{
    protected $attributes = [
        'name' => 'Jobs',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        if (isset($args['id'])) {
            return auth()->id() == $args['id'];
        }

        return true;
    }

    public function type(): Type
    {
        return GraphQL::paginate('Job');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'default' => 4,
            ],
            'page' => [
                'type' => Type::int(),
                'default' => 1,
            ],
            'except_by_id' => [
                'type' => Type::listOf(Type::int()),
                'default' => null,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $query = new Job;
        if (isset($args['except_by_id']) && is_array($args['except_by_id'])) {
            $query = $query->whereNotIn('id', $args['except_by_id']);
        }
        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
