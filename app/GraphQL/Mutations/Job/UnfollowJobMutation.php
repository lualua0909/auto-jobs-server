<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Job;

use App\Models\JobSaved;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UnfollowJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'unfollowJob',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return JobSaved::where([
            'job_id' => $args['job_id'],
            'user_id' => auth()->id(),
        ])->delete();
    }
}
