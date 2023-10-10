<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Delete;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
