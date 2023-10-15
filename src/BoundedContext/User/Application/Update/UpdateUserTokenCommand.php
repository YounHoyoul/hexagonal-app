<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Update;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class UpdateUserTokenCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $token
    ) {
    }
}
