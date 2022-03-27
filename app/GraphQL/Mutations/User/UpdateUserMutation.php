<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Storage;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
            'name' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
                'rules' => ['email', 'unique:users', 'min:3', 'max:255'],
            ],
            'phone' => [
                'type' => Type::string(),
                'rules' => ['unique:users', 'min:6', 'max:20'],
            ],
            'birth_date' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'street_name' => [
                'type' => Type::string(),
                'rules' => ['min:6'],
            ],
            'ward_id' => [
                'type' => Type::int(),
            ],
            'district_id' => [
                'type' => Type::int(),
            ],
            'province_id' => [
                'type' => Type::int(),
            ],
            'old_password' => [
                'type' => Type::string(),
                'rules' => ['min:6'],
            ],
            'password' => [
                'type' => Type::string(),
                'rules' => ['min:6'],
            ],
            'avatar' => [
                'type' => Type::string(),
            ],
            'cmnd_front' => [
                'type' => Type::string(),
            ],
            'cmnd_back' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $id = isset($args['id']) ? $args['id'] : auth()->id();
        $user = User::findOrFail($id);
        if (isset($args['old_password']) && isset($args['password']) && Hash::check($args['old_password'], $user->password)) {
            $args['password'] = bcrypt($args['password']);
        }
        $user->fill($args);
        $user->save();

        if (isset($args['avatar'])) {
            Storage::disk('avatar')->put("$id/avatar.webp", resize_image($args['avatar']));
        }

        if (isset($args['cmnd_front'])) {
            Storage::disk('users')->put("$id/cmnd_front.webp", resize_image($args['cmnd_front'], 1000));
        }

        if (isset($args['cmnd_back'])) {
            Storage::disk('users')->put("$id/cmnd_back.webp", resize_image($args['cmnd_back'], 1000));
        }

        return $user;
    }
}
