<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\BoundedContext\User\Domain\Actions\ResetPasswordAction;
use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserPasswordConfirmation;
use Src\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class ResetPasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ResetPasswordAction $action
    ) {
    }

    public function __invoke(ResetPasswordCommand $command): void
    {
        $this->action->__invoke(
            token: ResetToken::fromValue($command->token),
            email: UserEmail::fromValue($command->email),
            password: UserPassword::fromValue($command->password),
            password_confirmation: UserPasswordConfirmation::fromValue($command->password_confirmation)
        );
    }
}
