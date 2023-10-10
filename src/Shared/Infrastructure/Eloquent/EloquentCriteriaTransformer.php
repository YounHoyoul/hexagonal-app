<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\FilterOperator;

final class EloquentCriteriaTransformer
{
    public function __construct(
        private Criteria $criteria,
        private Model $model
    ) {
    }

    public function builder(): Builder
    {
        return $this->buildFilter(
            $this->buildOrderBy(
                $this->buildOffset(
                    $this->buildLimit(
                        $this->model->newModelQuery()
                    )
                )
            )
        );
    }

    private function buildFilter($query)
    {
        if ($this->criteria->filters === null) {
            return $query;
        }

        /** @var Filter $filter */
        foreach ($this->criteria->filters as $filter) {
            switch ($filter->operator) {
                case FilterOperator::EQUAL:
                    $query->where($filter->field, '=', $filter->value);
                    break;
                case FilterOperator::NOT_EQUAL:
                    $query->where($filter->field, '!=', $filter->value);
                    break;
            }
        }

        return $query;
    }

    private function buildOrderBy($query)
    {
        if ($this->criteria->orderList === null) {
            return $query;
        }

        /** @var Order $orderList */
        foreach ($this->criteria->orderList as $order) {
            $query->orderBy($order->orderBy, $order->orderType);
        }

        return $query;
    }

    private function buildOffset($query)
    {
        if ($this->criteria->offset === null) {
            return $query;
        }

        if ($this->criteria->offset > 0) {
            $query->skip($this->criteria->offset);
        }

        return $query;
    }

    private function buildLimit($query)
    {
        if ($this->criteria->limit === null) {
            return $query;
        }

        if ($this->criteria->limit > 0) {
            $query->limit($this->criteria->limit);
        }

        return $query;
    }
}
