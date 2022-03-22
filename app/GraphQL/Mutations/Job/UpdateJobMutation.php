<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Job;

use App\Models\Job;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateJobMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateJob',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Job');
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required'],
            ],
            'user_id' => [
                'type' => Type::int(),
            ],
            'employer_id' => [
                'type' => Type::int(),
            ],
            'action' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
            if (auth()->user()->role === 'user') {
                $Job = Job::where([
                    'job_id'=> $args['job_id'],
                    'user_id'=> auth()->id(),
                    'employer_id'=> $args['employer_id'],
                ])->first();

                // user được accept những Job [approved]
                if ($args['action'] === 'approved' && $Job->status === 2) {
                    $Job->status = 4;
                }
                else if ($args['action'] === 'rejected') {
                    $Job->status = 5;
                }
            } else if (auth()->user()->role === 'employer') {
                $Job = Job::where([
                    'job_id'=> $args['job_id'],
                    'employer_id'=> auth()->id(),
                    'user_id'=> $args['user_id'],
                ])->first();

                // employer được accept những Job [waiting, accepted, doing]
                if ($args['action'] === 'approved') {
                    if($Job->status === 1) {
                        $Job->status = 2;
                    } else if($Job->status === 4) {
                        $Job->status = 6;
                    } else if($Job->status === 6) {
                        $Job->status = 7;
                    }
                }
                else if ($args['action'] === 'rejected') {
                    $Job->status = 3;
                }
            }

            $Job->save();

            return $Job ?? null;
    }
}
