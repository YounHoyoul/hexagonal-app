<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Src\BoundedContext\User\Application\Create\CreateUserCommand;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQuery;
use Src\BoundedContext\User\Infrastructure\Http\Resources\UserResource;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;

final class CreateUserController
{
    public function __construct(
        private CommandBusInterface $commandBusInterface,
        private QueryBusInterface $queryBusInterface
    ) {
    }

    public function __invoke(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $userEmailVerifiedDate = null;
        $password = Hash::make($request->input('password'));
        $userRememberToken = null;

        $this->commandBusInterface->dispatch(new CreateUserCommand(
            name: $name,
            email: $email,
            password: $password
        ));

        $newUser = $this->queryBusInterface->ask(new GetUserByCriteriaQuery(
            name: $name,
            email: $email,
        ));

        return response(new UserResource($newUser), 201);
    }
}
