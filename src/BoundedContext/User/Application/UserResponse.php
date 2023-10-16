<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application;

use DateTime;
use Src\BoundedContext\User\Domain\User;
use Src\Shared\Domain\Bus\Query\ResponseInterface;

final class UserResponse implements ResponseInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?DateTime $emailVerifiedDate,
        public readonly ?string $rememberToken
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->id->value(),
            name: $user->name->value(),
            email: $user->email->value(),
            password: $user->password?->value(),
            emailVerifiedDate: $user->emailVerifiedDate?->value(),
            rememberToken: $user->rememberToken?->value()
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'emailVerifiedDate' => $this->emailVerifiedDate,
            'rememberToken' => $this->rememberToken,
        ];
    }
}
