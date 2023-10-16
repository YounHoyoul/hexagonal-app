<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Create;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $password_confirmation
    ) {
    }
}
