<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\Shared\Domain\Bus\Command\CommandInterface;

class UpdatePasswordCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $current_password,
        public readonly string $password,
        public readonly string $password_confirmation,
    ) {
    }
}
