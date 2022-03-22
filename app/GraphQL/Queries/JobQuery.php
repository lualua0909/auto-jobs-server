<?php

namespace App\GraphQL\Queries;

use App\Models\Job;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class JobQuery extends Query
{
    protected $attributes = [
        'name' => 'Job',
    ];

    public function type(): Type
    {
        return GraphQL::type('Job');
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
        $job = Job::findOrFail($args['id']);
        return $job;
    }
}