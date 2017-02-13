<?php declare(strict_types = 1);
/**
 * This file is part of laravel.ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\GraphQL\Queries;

use App\GraphQL\Queries\Support\QueryLimit;
use App\GraphQL\Serializers\ArticleSerializer;
use App\GraphQL\Types\ArticleType;
use App\Models\Article;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

/**
 * Class ArticlesQuery
 *
 * @package App\GraphQL
 */
class ArticlesQuery extends Query
{
    use QueryLimit;

    /**
     * @var array
     */
    protected $attributes = [
        'name'        => 'Article list query',
        'description' => 'Returns a list of available articles',
    ];

    /**
     * @return GraphQL\Type\Definition\ListOfType
     */
    public function type()
    {
        return Type::listOf(GraphQL::type(ArticleType::getName()));
    }

    /**
     * @return array
     */
    public function args()
    {
        return $this->argumentsWithLimit([
            'id'     => [
                'type'        => Type::id(),
                'description' => 'Article identifier',
            ],
            'status' => [
                'type'        => Article\Status::toGraphQL(),
                'description' => 'Article visibility status',
            ],
        ]);
    }

    /**
     * @param $root
     * @param array $args
     * @return \Illuminate\Support\Collection
     * @throws \InvalidArgumentException
     */
    public function resolve($root, array $args = [])
    {
        $query = Article::query()
            ->with('user')
            ->with('tags');

        $query = $this->paginate($query, $args);

        foreach ($args as $field => $value) {
            $query = $query->where($field, $value);
        }

        return ArticleSerializer::collection($query->get());
    }
}