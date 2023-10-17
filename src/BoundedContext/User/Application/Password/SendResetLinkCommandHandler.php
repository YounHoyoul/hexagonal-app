<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\BoundedContext\User\Domain\Actions\SendResetLinkAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class SendResetLinkCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SendResetLinkAction $action
    ) {
    }

    public function __invoke(SendResetLinkCommand $command): void
    {
        $this->action->__invoke(
            email: UserEmail::fromValue($command->email)
        );
    }
}
