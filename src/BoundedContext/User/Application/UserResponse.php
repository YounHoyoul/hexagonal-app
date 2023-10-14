<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application;

use Src\BoundedContext\User\Domain\User;
use Src\Shared\Domain\Bus\Query\ResponseInterface;

final class UserResponse implements ResponseInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->id->value(),
            $user->name->value(),
            $user->email->value()
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
