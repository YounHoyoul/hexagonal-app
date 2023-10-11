<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Create;

use Src\BoundedContext\User\Domain\Actions\CreateUserAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CreateUserAction $action
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $this->action->__invoke(
            name: UserName::fromValue($command->name),
            email: UserEmail::fromValue($command->email),
            password: UserPassword::fromValue($command->password),
        );
    }
}
