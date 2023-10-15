<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers\API;

use Illuminate\Http\Request;
use Src\BoundedContext\User\Application\Create\CreateUserCommand;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQuery;
use Src\BoundedContext\User\Infrastructure\Http\Resources\UserResource;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CreateUserController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $userEmailVerifiedDate = null;
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $userRememberToken = null;

        $this->commandBus->dispatch(new CreateUserCommand(
            name: $name,
            email: $email,
            password: $password,
            password_confirmation: $password_confirmation
        ));

        $newUser = $this->queryBus->ask(new GetUserByCriteriaQuery(
            new Criteria(filters: [
                new Filter('email', FilterOperator::EQUAL, $email),
                new Filter('name', FilterOperator::EQUAL, $name),
            ])
        ));

        return response(new UserResource($newUser), 201);
    }
}
