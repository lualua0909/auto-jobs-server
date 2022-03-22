<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Job;

use App\Models\Job;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteJob',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return Type::boolean();
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
        $category = Job::findOrFail($args['id']);
        return $category->delete();
    }
}
