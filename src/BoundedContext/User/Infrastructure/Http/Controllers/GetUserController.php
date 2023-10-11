<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Src\BoundedContext\User\Application\Get\GetUserByIdQuery;
use Src\BoundedContext\User\Infrastructure\Http\Resources\UserResource;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class GetUserController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request, int $id)
    {
        $user = $this->queryBus->ask(new GetUserByIdQuery($id));

        return response(new UserResource($user));
    }
}
