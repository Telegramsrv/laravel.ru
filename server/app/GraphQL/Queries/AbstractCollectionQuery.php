<?php
/**
 * This file is part of laravel.su package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\GraphQL\Queries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\GraphQL\Queries\Support\QueryLimit;
use App\GraphQL\Queries\Support\WhereInSelection;

/**
 * Class AbstractCollectionQuery.
 */
abstract class AbstractCollectionQuery extends AbstractQuery
{
    use QueryLimit;
    use WhereInSelection;

    /**
     * @return array
     */
    public function args(): array
    {
        $args = $this->queryArguments();

        $args = $this->argumentsWithLimit($args);
        $args = $this->argumentsWithWhereIn($args);

        return $args;
    }

    /**
     * @param string $model
     * @param array  $args
     * @return Builder|Model <T>
     * @internal param $ string|Model|Model<T> $model
     */
    protected function queryFor(string $model, array $args = []): Builder
    {
        $query = $model::query();

        $query = $this->queryWithLimit($query, $args);
        $query = $this->queryWithWhereIn($query, $args);

        return $query;
    }
}
