<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Entities;

use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;

class PasswordResetToken
{
    public function __construct(
        public readonly UserEmail $email,
        public readonly ResetToken $token
    ) {
    }

    public static function create(
        UserEmail $email,
        ResetToken $token,
    ): PasswordResetToken {
        return new self(
            email: $email,
            token: $token,
        );
    }
}
