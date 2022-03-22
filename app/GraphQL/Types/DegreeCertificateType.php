<?php

namespace App\GraphQL\Types;

use App\Models\DegreeCertificate;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DegreeCertificateType  extends GraphQLType
{
    protected $attributes = [
        'name' => 'DegreeCertificate',
        'description' => 'A type of DegreeCertificate'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int())
            ],
            'title' => [
                'type' => Type::nonNull(Type::string())
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string())
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }
}