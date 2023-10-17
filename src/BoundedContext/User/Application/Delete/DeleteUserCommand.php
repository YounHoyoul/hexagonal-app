<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Delete;

use Closure;
use Src\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $password,
        public readonly ?Closure $callback = null
    ) {
    }
}
