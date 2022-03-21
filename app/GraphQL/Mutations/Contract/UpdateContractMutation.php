<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Contract;

use App\Models\Contract;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateContractMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateContract',
        'description' => 'A mutation',
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
        if ($args['action'] == 'waiting') {
            $contract = Contract::create([
                'job_id' => $args['job_id'],
                'user_id' => auth()->id(),
                'status' => 'waiting',
            ]);

            return $contract;
        } else {
            if (auth()->user()->role === 'user') {
                $contract = Contract::where([
                    'job_id', $args['job_id'],
                    'user_id', auth()->id(),
                    'employer_id', $args['employer_id'],
                ])->first();

            } else if (auth()->user()->role === 'employer') {
                $contract = Contract::where([
                    'job_id', $args['job_id'],
                    'employer_id', auth()->id(),
                    'user_id', $args['user_id'],
                ])->first();
            }

            return $contract->save();
        }

        return null;
    }
}
