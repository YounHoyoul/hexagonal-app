<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain;

use DateTime;
use Src\BoundedContext\User\Domain\Events\UserWasCreated;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        public readonly UserName $name,
        public readonly UserEmail $email,
        public readonly ?UserPassword $password = null,
        public readonly ?UserEmailVerifiedDate $emailVerifiedDate = null,
        public readonly ?UserRememberToken $rememberToken = null,
        public readonly ?UserId $id = null
    ) {
    }

    public static function fromPrimitives(
        ?int $id,
        string $name,
        string $email,
        ?string $password,
        ?DateTime $emailVerifiedDate,
        ?string $rememberToken,
    ): User {
        return new self(
            id: ($id ? UserId::fromValue($id) : null),
            name: UserName::fromValue($name),
            email: UserEmail::fromValue($email),
            password: ($password ? UserPassword::fromValue($password) : null),
            emailVerifiedDate: ($emailVerifiedDate ? UserEmailVerifiedDate::fromValue($emailVerifiedDate) : null),
            rememberToken: ($rememberToken ? UserRememberToken::fromValue($rememberToken) : null)
        );
    }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserEmailVerifiedDate $emailVerifiedDate = null,
        UserRememberToken $rememberToken = null
    ): User {
        $user = new self(
            name: $name,
            email: $email,
            password: $password,
            emailVerifiedDate: $emailVerifiedDate,
            rememberToken: $rememberToken
        );

        $user->record(new UserWasCreated($name->value, $email->value));

        return $user;
    }
}
