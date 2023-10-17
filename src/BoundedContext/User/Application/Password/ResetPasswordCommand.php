<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\Shared\Domain\Bus\Command\CommandInterface;

class ResetPasswordCommand implements CommandInterface
{
    public function __construct(
        public readonly string $token,
        public readonly string $email,
        public readonly string $password,
        public readonly string $password_confirmation
    ) {
    }
}
