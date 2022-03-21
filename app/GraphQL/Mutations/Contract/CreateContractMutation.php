<?php

namespace App\GraphQL\Mutations\Contract;

use App\Models\Company;
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
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'string'],
            ],
            'email' => [
                'type' => Type::string(),
                'rules' => ['email', 'unique:Contracts', 'min:3', 'max:255'],
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'unique:Contracts', 'min:6', 'max:20'],
            ],
            'street_name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'min:6'],
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
            'is_employer' => [
                'type' => Type::int(),
            ],
            'company_type_id' => [
                'type' => Type::int(),
            ],
            'company_size' => [
                'type' => Type::int(),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'min:6'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        try {
            \DB::beginTransaction();
            $args['password'] = bcrypt($args['password']);
            $Contract = Contract::create(collect($args)->only(['name', 'email', 'description', 'phone', 'street_name', 'ward_id', 'district_id', 'province_id', 'password'])->toArray());
            
            $Contract->role = 'Contract';
            $Contract->assignRole('Contract');

            if ($Contract && $Contract->id && isset($args['company_type_id']) && $args['company_type_id']) {
                $company = Company::create([
                    'name' => $args['name'],
                    'company_type_id' => $args['company_type_id'],
                    'company_size' => $args['company_size'],
                    'phone' => $args['phone'],
                    'total_rating' => 0,
                    'street_name' => $args['street_name'],
                    'ward_id' => $args['ward_id'],
                    'district_id' => $args['district_id'],
                    'province_id' => $args['province_id'],
                    'description' => $args['description'],
                    'email' => $args['email'],
                    'representative_id' => $Contract->id,
                    'created_by' => $Contract->id,
                ]);

                $Contract->role = 'employer';
                $Contract->removeRole('Contract');
                $Contract->assignRole('employer');
                $Contract->save();
            }

            \DB::commit();
            return $Contract;
        } catch (\Exception$e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }
}
