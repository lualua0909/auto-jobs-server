<?php

namespace App\GraphQL\Mutations\Contract;

use App\Models\Job;
use App\Models\Contract;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateContractMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createContract',
        'description' => 'Contract mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Contract');
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
            ]
        ];
    }

    public function resolve($root, $args)
    {
            $job = Job::find($args['job_id']);

            if(auth()->user()->role === 'user') {
                $contract = Contract::firstOrCreate([
                    'job_id' => $args['job_id'],
                    'user_id' => auth()->id(),
                    'employer_id' => $job->created_by,
                ], ['status' => 1,]);

                return $contract;
            } else if(auth()->user()->role === 'employer') {
                $contract = Contract::firstOrCreate([
                    'job_id' => $args['job_id'],
                    'user_id' => $args['user_id'],
                    'employer_id' => auth()->id(),
                ],['status' => 2,]);

                return $contract;
            }

            return $contract ?? null;
    }
}
