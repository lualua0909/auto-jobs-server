<?php

namespace App\GraphQL\Mutations\Job;

use App\Models\Job;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createJob',
        'description' => 'Job mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Job');
    }

    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
            ],
            'hourly_salary' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required'],
            ],
            'requirements' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
            ],
            'benefits' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
            ],
            'number_of_workers' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required'],
            ],
            'street_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'ward_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'district_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'province_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'start_time' => [
                'type' => Type::string(),
            ],
            'end_time' => [
                'type' => Type::string(),
            ],
            'lat' => [
                'type' => Type::float(),
            ],
            'long' => [
                'type' => Type::float(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $params = array_merge($args, ['created_by' => auth()->id()]);
        $job = Job::fill($params);
        $job->save();
        return $job ?? null;
    }
}
