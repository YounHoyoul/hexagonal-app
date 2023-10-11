<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\BoundedContext\User\Application\Listing\SearchUsersQuery;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class SearcUsersController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request)
    {
        $filters = $request->get('filters') ?? [];
        $orderBy = $request->get('order_by') ?? [];
        $order = $request->get('order') ?? '';
        $limit = $request->get('limit') ?? 10;
        $offset = $request->get('offset') ?? 0;

        $users = $this->queryBus->ask(
            new SearchUsersQuery(
                filters: $filters,
                orderBy: $orderBy,
                order: $order,
                offset: $offset,
                limit: $limit
            )
        );

        return new JsonResponse(
            [
                'users' => $users,
            ],
            Response::HTTP_OK,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
