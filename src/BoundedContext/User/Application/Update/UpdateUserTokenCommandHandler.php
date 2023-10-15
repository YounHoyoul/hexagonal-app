<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Update;

use Src\BoundedContext\User\Domain\Actions\UpdateUserTokenAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateUserTokenCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UpdateUserTokenAction $action
    ) {
    }

    public function __invoke(UpdateUserTokenCommand $command): void
    {
        $this->action->__invoke(
            id: UserId::fromValue($command->id),
            token: UserRememberToken::fromValue($command->token),
        );
    }
}
