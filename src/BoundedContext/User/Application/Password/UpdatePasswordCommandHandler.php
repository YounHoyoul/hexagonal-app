<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\BoundedContext\User\Domain\Actions\UpdatePasswordAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserCurrentPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserPasswordConfirmation;

class UpdatePasswordCommandHandler
{
    public function __construct(
        private UpdatePasswordAction $action
    ) {
    }

    public function __invoke(UpdatePasswordCommand $command): void
    {
        $this->action->__invoke(
            id: UserId::fromValue($command->id),
            password: UserPassword::fromValue($command->password),
            current_password: UserCurrentPassword::fromValue($command->current_password),
            password_confirmation: UserPasswordConfirmation::fromValue($command->password_confirmation)
        );
    }
}
