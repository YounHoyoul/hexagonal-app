<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Update;

use Src\BoundedContext\User\Domain\Actions\UpdateUserProfileAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateUserProfileCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UpdateUserProfileAction $action
    ) {
    }

    public function __invoke(UpdateUserProfileCommand $command): void
    {
        $this->action->__invoke(
            id: UserId::fromValue($command->id),
            name: UserName::fromValue($command->name),
            email: UserEmail::fromValue($command->email),
        );
    }
}
