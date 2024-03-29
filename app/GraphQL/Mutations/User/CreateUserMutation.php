<?php

namespace App\GraphQL\Mutations\User;

use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
        'description' => 'User mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
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
                'rules' => ['email', 'unique:users', 'min:3', 'max:255'],
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'unique:users', 'min:6', 'max:20'],
            ],
            'birth_date' => [
                'type' => Type::string(),
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
            'lat' => [
                'type' => Type::float(),
            ],
            'long' => [
                'type' => Type::float(),
            ],
            'lat_delta' => [
                'type' => Type::float(),
            ],
            'long_delta' => [
                'type' => Type::float(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        try {
            \DB::beginTransaction();
            $args['password'] = bcrypt($args['password']);
            $user = User::create(collect($args)->only(['name', 'email', 'description', 'phone', 'birth_date', 'street_name', 'ward_id', 'district_id', 'province_id', 'password', 'lat', 'long', 'lat_delta', 'long_delta'])->toArray());

            $user->role = 'user';
            $user->assignRole('user');

            if ($user && $user->id && isset($args['company_type_id']) && $args['company_type_id']) {
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
                    'representative_id' => $user->id,
                    'created_by' => $user->id,
                ]);

                $user->role = 'employer';
                $user->removeRole('user');
                $user->assignRole('employer');
                $user->save();

                if ($user) {
                    $notification = new Notification;
                    $notification->fill([
                        'template_id' => 2,
                        'user_id' => $user->id,
                    ]);
                    $notification->save();
                }
            }

            $user->save();
            
            \DB::commit();
            return $user;
        } catch (\Exception$e) {
            \DB::rollback();
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
