<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Listing;

use Src\BoundedContext\User\Application\UsersResponse;
use Src\BoundedContext\User\Domain\Actions\SearchUsersAction;
use Src\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Order;
use Src\Shared\Domain\Criteria\OrderType;

final class SearchUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private SearchUsersAction $action)
    {
    }

    public function __invoke(SearchUsersQuery $query): UsersResponse
    {
        $order = $query->order;
        $criteria = new Criteria(
            array_map(function($filter){
                return null;
            }, $query->filters),
            array_map(function ($orderBy) use ($order) {
                return new Order(
                    orderBy: $orderBy,
                    orderType: $order === 'desc' ? OrderType::DESC : OrderType::ASC
                );
            }, $query->orderBy),
            $query->offset,
            $query->limit
        );

        $users = $this->action->__invoke($criteria);

        return UsersResponse::fromUsers($users);
    }
}
