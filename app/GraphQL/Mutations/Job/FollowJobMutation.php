<?php

namespace App\GraphQL\Mutations\Job;

use App\Models\JobSaved;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class FollowJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'followJob',
        'description' => 'Job mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('JobSaved');
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $job = JobSaved::firstOrCreate(
            [
                'job_id' => $args['job_id'],
                'user_id' => auth()->id(),
            ], []
        );
        return $job ?? null;
    }
}
