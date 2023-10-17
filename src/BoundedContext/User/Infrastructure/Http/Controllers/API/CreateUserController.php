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
        $this->commandBus->dispatch(new CreateUserCommand(
            name: $request->name,
            email: $request->email,
            password: $request->password,
            password_confirmation: $request->password_confirmation
        ));

        $newUser = $this->queryBus->ask(new GetUserByCriteriaQuery(
            new Criteria(filters: [
                new Filter('email', FilterOperator::EQUAL, $request->email),
            ])
        ));

        return response(new UserResource($newUser), 201);
    }
}
