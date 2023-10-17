<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers\API;

use Illuminate\Http\Request;
use Src\BoundedContext\User\Application\Get\GetUserByIdQuery;
use Src\BoundedContext\User\Application\Update\UpdateUserCommand;
use Src\BoundedContext\User\Infrastructure\Http\Resources\UserResource;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class UpdateUserController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request, int $id)
    {
        $this->commandBus->dispatch(new UpdateUserCommand(
            id: $id,
            name: $request->name,
            email: $request->email
        ));

        $user = $this->queryBus->ask(new GetUserByIdQuery($id));

        return response(new UserResource($user));
    }
}
