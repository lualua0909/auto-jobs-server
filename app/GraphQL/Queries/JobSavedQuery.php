<?php

namespace App\GraphQL\Queries;

use App\Models\JobSaved;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class JobSavedQuery extends Query
{
    protected $attributes = [
        'name' => 'JobSaved',
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
        return GraphQL::paginate('JobSaved');
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
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return JobSaved::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
