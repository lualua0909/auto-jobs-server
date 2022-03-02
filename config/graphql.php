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
                App\GraphQL\Queries\ProfileQuery::class,
            ],
        ],
        'secret' => [
            'query' => [
                'user' => App\GraphQL\Queries\UserQuery::class,
                'users' => App\GraphQL\Queries\UsersQuery::class,
            ],
            'mutation' => [
                'createUser' => App\GraphQL\Mutations\User\CreateUserMutation::class,
                'deleteUser' => App\GraphQL\Mutations\User\DeleteUserMutation::class,
                'updateUser' => App\GraphQL\Mutations\User\UpdateUserMutation::class,
            ],
            'middleware' => ['auth:api'],
        ],
    ],
    'types' => [
        'User' => App\GraphQL\Types\UserType::class,
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
