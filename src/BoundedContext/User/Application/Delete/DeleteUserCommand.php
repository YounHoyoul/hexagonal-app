<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Delete;

use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Bus\Command\CommandInterface;
use Src\Shared\Domain\Validation\ValidateInterface;

final class DeleteUserCommand implements CommandInterface, ValidateInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }

    public function rules(): array
    {
        return [
            'id' => UserId::rule(),
        ];
    }
}
