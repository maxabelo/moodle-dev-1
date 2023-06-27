<?php

declare(strict_types=1);

namespace Infrastructure\Common\Repository;

use Ddd\Domain\Entity\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginator
{   
    /**
     * Create a Iterable
     * 
     * If the pagination data is provided, creates a Paginator, 
     * otherwise it returns a Collection.
     *
     * @param array $list
     * @param array $query
     * @param integer $total
     * @return iterable
     */
    protected function createIterable(
        array $list = [], 
        array $query, 
        int $total
    ) : iterable {

        $collection = new Collection($list);

        return isset($query['pagination'])
            ? new LengthAwarePaginator(
                $collection, 
                $total, 
                (int) $query['pagination']['limit'], 
                (int) $query['page']
            )
            : $collection
        ;
    }
}