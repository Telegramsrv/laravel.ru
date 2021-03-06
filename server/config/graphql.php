<?php

declare(strict_types=1);

return [
    /*
    | The prefix for routes
     */
    'prefix'               => 'graphql',

    /*
    | The routes to make GraphQL request. Either a string that will apply
    | to both query and mutation or an array containing the key 'query' and/or
    | 'mutation' with the according Route
    |
    | Example:
    |
    | Same route for both query and mutation
    |
    | 'routes' => 'path/to/query/{graphql_schema?}',
    |
    | or define each routes
    |
    | 'routes' => [
    |     'query' => 'query/{graphql_schema?}',
    |     'mutation' => 'mutation/{graphql_schema?}',
    |     'mutation' => 'graphiql'
    | ]
    |
    | you can also disable routes by setting routes to null
    |
    | 'routes' => null,
    |
    */
    'routes'               => '{graphql_schema?}',

    /*
    | The controller to use in GraphQL request. Either a string that will apply
    | to both query and mutation or an array containing the key 'query' and/or
    | 'mutation' with the according Controller and method
    |
    | Example:
    |
    | 'controllers' => [
    |     'query' => '\Folklore\GraphQL\GraphQLController@query',
    |     'mutation' => '\Folklore\GraphQL\GraphQLController@mutation'
    | ]
    |
    */
    'controllers'          => \Folklore\GraphQL\GraphQLController::class . '@query',

    /*
    | The name of the input that contain variables when you query the endpoint.
    | Some library use "variables", you can change it here. "params" will stay
    | the default for now but will be changed to "variables" in the next major
    | release.
    */
    'variables_input_name' => 'variables',

    /*
    | Any middleware for the graphql route group
    */
    'middleware'           => [
        'api',
    ],

    /*
    | Config for GraphiQL (https://github.com/graphql/graphiql).
    | To disable GraphiQL, set this to null.
    */
    'graphiql'             => [
        'routes'     => '/graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
    ],

    /*
    | The name of the default schema used when no argument is provided
    | to GraphQL::schema() or when the route is used without the graphql_schema
    | parameter.
    */
    'schema'               => 'default',

    /*
     | Just a schemas
     */
    'schemas'              => [
        'default' => [
            'query'    => [
                'articles'  => \App\GraphQL\Queries\ArticlesQuery::class,
                'users'     => \App\GraphQL\Queries\UsersQuery::class,
                'tags'      => \App\GraphQL\Queries\TagsQuery::class,
                'tips'      => \App\GraphQL\Queries\TipsQuery::class,
                'docs'      => \App\GraphQL\Queries\DocsQuery::class,
                'search'    => \App\GraphQL\Queries\SearchQuery::class,
                'auth'      => \App\GraphQL\Queries\AuthQuery::class,
                'paginator' => \App\GraphQL\Queries\PaginatorQuery::class,
            ],
            'mutation' => [
                'registration' => \App\GraphQL\Mutations\RegistrationMutation::class,
            ],
        ],
    ],

    'types'           => [
        'Article'      => \App\GraphQL\Types\ArticleType::class,
        'User'         => \App\GraphQL\Types\UserType::class,
        'AuthUser'     => \App\GraphQL\Types\AuthUserType::class,
        'Tag'          => \App\GraphQL\Types\TagType::class,
        'Tip'          => \App\GraphQL\Types\TipType::class,
        'Docs'         => \App\GraphQL\Types\DocsType::class,
        'DocsPage'     => \App\GraphQL\Types\DocsPageType::class,
        'SearchResult' => \App\GraphQL\Types\SearchResultType::class,
        'Paginator'    => \App\GraphQL\Types\PaginatorType::class,
    ],

    /*
    | This callable will received every Error objects for each errors GraphQL catch.
    | The method should return an array representing the error.
    |
    | Typically:
    | [
    |     'message' => '',
    |     'locations' => []
    | ]
    |
    */
    'error_formatter' => [\Folklore\GraphQL\GraphQL::class, 'formatError'],

    /*
    | Options to limit the query complexity and depth. See the doc
    | @ https://github.com/webonyx/graphql-php#security
    | for details. Disabled by default.
    */
    'security'        => [
        'query_max_complexity' => null,
        'query_max_depth'      => null,
    ],
];
