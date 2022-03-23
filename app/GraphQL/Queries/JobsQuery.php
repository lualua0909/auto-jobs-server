<?php

namespace App\GraphQL\Queries;

use App\Models\Contract;
use App\Models\Job;
use App\Models\JobSaved;
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
        $query = $query->paginate($args['limit'], ['*'], 'page', $args['page']);

        /** @var SelectFields $fields */
        $select = $getSelectFields()->getSelect();

        if (in_array('status', $select)) {
            foreach ($query as $row) {
                $row->status = Contract::where([
                    'job_id' => $row->id,
                    'user_id' => auth()->id(),
                ])->first()->status ?? 'not_applied';

                $row->isSaved = JobSaved::where([
                    'job_id' => $row->id,
                    'user_id' => auth()->id(),
                ])->first() ? true : false;
            }
        }

        return $query;
    }
}
