<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Src\BoundedContext\User\Application\Delete\DeleteUserCommand;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;

final class DeleteUserController
{
    public function __construct(
        private CommandBusInterface $commandBusInterface
    ) {
    }

    public function __invoke(Request $request, int $id)
    {
        $this->commandBusInterface->dispatch(new DeleteUserCommand($id));
    }
}
