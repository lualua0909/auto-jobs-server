<?php

namespace App\GraphQL\Queries;

use App\Models\Company;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class CompanyListQuery extends Query
{
    protected $attributes = [
        'name' => 'CompanyList',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return true;
    }

    public function type(): Type
    {
        return GraphQL::paginate('Company');
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
            'orderBy' => [
                'type' => Type::string(),
                'default' => 'id',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return Company::orderBy($args['orderBy'], 'desc')
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
