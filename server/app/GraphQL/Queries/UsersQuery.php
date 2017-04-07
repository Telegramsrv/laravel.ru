<?php

/**
 * This file is part of laravel.su package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use App\GraphQL\Kernel\Paginator;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Collection;
use GraphQL\Type\Definition\ListOfType;
use App\GraphQL\Serializers\UserSerializer;

/**
 * Class UsersQuery.
 */
class UsersQuery extends AbstractQuery
{
    use Paginator;

    /**
     * @var array
     */
    protected $attributes = [
        'name'        => 'Users list query',
        'description' => 'Returns a list of users',
    ];

    /**
     * @return ListOfType
     */
    public function type(): ListOfType
    {
        return Type::listOf(\GraphQL::type('User'));
    }

    /**
     * @return array
     */
    protected function queryArguments(): array
    {
        return Paginator\PaginatorConfiguration::withPaginatorArguments([

        ]);
    }

    /**
     * @param        $root
     * @param  array $args
     * @return \Traversable
     */
    public function resolve($root, array $args = []): \Traversable
    {
        $query = $this->queryFor(User::class, $args);

        return $this->paginate($query, $query->count())
            ->withArgs($args)
            ->use(UserSerializer::class)
            ->as('users');
    }
}
