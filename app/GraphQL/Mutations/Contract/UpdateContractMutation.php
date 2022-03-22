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
            if (auth()->user()->role === 'user') {
                $contract = Contract::where([
                    'job_id'=> $args['job_id'],
                    'user_id'=> auth()->id(),
                    'employer_id'=> $args['employer_id'],
                ])->first();

                // user được accept những contract [approved]
                if ($args['action'] === 'approved' && $contract->status === 2) {
                    $contract->status = 4;
                }
                else if ($args['action'] === 'rejected') {
                    $contract->status = 5;
                }
            } else if (auth()->user()->role === 'employer') {
                $contract = Contract::where([
                    'job_id'=> $args['job_id'],
                    'employer_id'=> auth()->id(),
                    'user_id'=> $args['user_id'],
                ])->first();

                // employer được accept những contract [waiting, accepted, doing]
                if ($args['action'] === 'approved') {
                    if($contract->status === 1) {
                        $contract->status = 2;
                    } else if($contract->status === 4) {
                        $contract->status = 6;
                    } else if($contract->status === 6) {
                        $contract->status = 7;
                    }
                }
                else if ($args['action'] === 'rejected') {
                    $contract->status = 3;
                }
            }

            $contract->save();

            return $contract ?? null;
    }
}
