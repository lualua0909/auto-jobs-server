<?php

return [
    'prefix' => 'graphql',
    'routes' => '{graphql_schema?}',
    'controllers' => \Rebing\GraphQL\GraphQLController::class . '@query',
    'middleware' => [],
    'route_group_attributes' => [],
    'default_schema' => 'default',
    'schemas' => [
        'default' => [
            'query' => [
                'user' => App\GraphQL\Queries\UserQuery::class,
                'wards' => App\GraphQL\Queries\WardsQuery::class,
                'districts' => App\GraphQL\Queries\DistrictsQuery::class,
                'provinces' => App\GraphQL\Queries\ProvincesQuery::class,
            ],
            'mutation' => [
                'createUser' => App\GraphQL\Mutations\User\CreateUserMutation::class,
            ],
        ],
        'secret' => [
            'query' => [
                'user' => App\GraphQL\Queries\UserQuery::class,
                'users' => App\GraphQL\Queries\UsersQuery::class,
                'job' => App\GraphQL\Queries\JobQuery::class,
                'jobs' => App\GraphQL\Queries\JobsQuery::class,
                'company' => App\GraphQL\Queries\CompanyQuery::class,
                'companyList' => App\GraphQL\Queries\CompanyListQuery::class,
                'degreeCertificateList' => App\GraphQL\Queries\DegreeCertificateListQuery::class,
                'notifications' => App\GraphQL\Queries\NotificationsQuery::class,
                'notification' => App\GraphQL\Queries\NotificationQuery::class,
                'contracts' => App\GraphQL\Queries\ContractsQuery::class,
                'contract' => App\GraphQL\Queries\ContractQuery::class,
            ],
            'mutation' => [
                'deleteUser' => App\GraphQL\Mutations\User\DeleteUserMutation::class,
                'updateUser' => App\GraphQL\Mutations\User\UpdateUserMutation::class,
                // 'createJob' => App\GraphQL\Mutations\Job\CreateJobMutation::class,
                // 'updateJob' => App\GraphQL\Mutations\Job\UpdateJobMutation::class,
                // 'deleteJob' => App\GraphQL\Mutations\Job\DeleteJobMutation::class,
                'createContract' => App\GraphQL\Mutations\Contract\CreateContractMutation::class,
                'updateContract' => App\GraphQL\Mutations\Contract\UpdateContractMutation::class,

            ],
            'middleware' => ['auth:api'],
        ],
    ],
    'types' => [
        'User' => App\GraphQL\Types\UserType::class,
        'Ward' => App\GraphQL\Types\WardType::class,
        'District' => App\GraphQL\Types\DistrictType::class,
        'Province' => App\GraphQL\Types\ProvinceType::class,
        'Job' => App\GraphQL\Types\JobType::class,
        'Company' => App\GraphQL\Types\CompanyType::class,
        'DegreeCertificate' => App\GraphQL\Types\DegreeCertificateType::class,
        'CompanyType' => App\GraphQL\Types\CompanyTypeType::class,
        'Notification' => App\GraphQL\Types\NotificationType::class,
        'NotificationTemplate' => App\GraphQL\Types\NotificationTemplateType::class,
        'ContractStatus' => App\GraphQL\Types\ContractStatusType::class,
        'ContractHistory' => App\GraphQL\Types\ContractHistoryType::class,
        'Contract' => App\GraphQL\Types\ContractType::class,
    ],
    'lazyload_types' => true,
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key' => 'variables',

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    'graphiql' => [
        'prefix' => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],

    'defaultFieldResolver' => null,

    'headers' => [],

    'json_encoding_options' => 0,
];
