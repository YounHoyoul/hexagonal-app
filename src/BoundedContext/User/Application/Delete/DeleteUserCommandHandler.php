<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Delete;

use Src\BoundedContext\User\Domain\Actions\DeleteUserAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserCurrentPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DeleteUserAction $action
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->action->__invoke(
            id : UserId::fromValue($command->id),
            password: UserCurrentPassword::fromValue($command->password),
            callback: $command->callback
        );
    }
}
