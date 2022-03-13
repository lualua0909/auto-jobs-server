<?php

namespace App\GraphQL\Queries;

use App\Models\Company;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class CompanyQuery extends Query
{
    protected $attributes = [
        'name' => 'Company',
    ];

    public function type(): Type
    {
        return GraphQL::type('Company');
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
        $Company = Company::findOrFail($args['id']);
        return auth()->id() === $Company->created_by ? $Company : null;
    }
}
