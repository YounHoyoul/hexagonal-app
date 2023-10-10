<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Src\BoundedContext\User\Application\Get\GetUserByIdQuery;
use Src\BoundedContext\User\Application\Update\UpdateUserCommand;
use Src\BoundedContext\User\Infrastructure\Http\Resources\UserResource;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class UpdateUserController
{
    public function __construct(
        private CommandBusInterface $commandBusInterface,
        private QueryBusInterface $queryBusInterface
    ) {
    }

    public function __invoke(Request $request, int $id)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $userEmailVerifiedDate = null;
        $password = Hash::make($request->input('password'));
        $userRememberToken = null;

        $this->commandBusInterface->dispatch(new UpdateUserCommand(
            id: $id,
            name: $name,
            email: $email,
            password: $password
        ));

        $user = $this->queryBusInterface->ask(new GetUserByIdQuery($id));

        return response(new UserResource($user));
    }
}
