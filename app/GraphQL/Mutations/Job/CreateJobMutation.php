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
        ];
    }

    public function resolve($root, $args)
    {
            $job = Job::create(
                [
                    'title' => $args['title'],
                    'description' => $args['description'],
                    'hourly_salary' => $args['hourly_salary'],
                    'requirements' => $args['requirements'],
                    'benefits' => $args['benefits'],
                    'number_of_workers' => $args['number_of_workers'],
                    'street_name' => $args['street_name'],
                    'ward_id' => $args['ward_id'],
                    'district_id' => $args['district_id'],
                    'province_id' => $args['province_id'],
                    'created_by' => auth()->id()
                ]
            );
            return $job ?? null;
    }
}
