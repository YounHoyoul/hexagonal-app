<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Password;

use Src\Shared\Domain\Bus\Command\CommandInterface;

final class SendResetLinkCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email
    ) {
    }
}
