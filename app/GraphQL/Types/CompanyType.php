<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CompanyType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Company',
        'description' => 'A type of Company',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'company_type_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'company_size' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'total_rating' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'street_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'representative_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'created_by' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'ward' => [
                'type' => GraphQL::type('Ward'),
            ],
            'district' => [
                'type' => GraphQL::type('District'),
            ],
            'province' => [
                'type' => GraphQL::type('Province'),
            ],
            'companyType' => [
                'type' => GraphQL::type('CompanyType'),
            ],
            'jobs' => [
                'type' => Type::listOf(GraphQL::type('Job')),
            ],
        ];
    }
}
