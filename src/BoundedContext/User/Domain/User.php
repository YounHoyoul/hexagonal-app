<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain;

use InvalidArgumentException;
use Src\BoundedContext\User\Domain\Events\UserWasCreated;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Aggregate\AggregateRoot;
use Src\Shared\Domain\Validation\ValidationCollection;
use Src\Shared\Domain\Validation\ValidationError;

final class User extends AggregateRoot
{
    public function __construct(
        public readonly UserName $name,
        public readonly UserEmail $email,
        public readonly UserEmailVerifiedDate $emailVerifiedDate,
        public readonly UserPassword $password,
        public readonly UserRememberToken $rememberToken
    ) {
    }

    public static function fromPrimitives(string $name, string $email): User
    {
        return new self(
            email: UserEmail::fromValue($email),
            name: UserName::fromValue($name),
            emailVerifiedDate: UserEmailVerifiedDate::fromValue(null),
            password: UserPassword::fromValue(null),
            rememberToken: UserRememberToken::fromValue(null)
        );
    }

    // public static function canCreate(
    //     UserName $name,
    //     UserEmail $email,
    //     UserPassword $password
    // ): ValidationCollection
    // {
    //     $error = [];

    //     if(null === $name || empty($name->value()))
    //     {
    //         $error[] = new ValidationError("name","Name is required");
    //     }

    //     if(null === $email || empty($email->value()))
    //     {
    //         $error[] = new ValidationError("email","Email is required");
    //     }

    //     if(null === $password || empty($password->value()))
    //     {
    //         $error[] = new ValidationError("password","Password is required");
    //     }

    //     return new ValidationCollection($error);
    // }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserEmailVerifiedDate $emailVerifiedDate,
        UserPassword $password,
        UserRememberToken $rememberToken
    ): User {
        // if(self::canCreate($name, $email, $password)->any()) {
        //     throw new InvalidArgumentException();
        // }

        $user = new self($name, $email, $emailVerifiedDate, $password, $rememberToken);

        $user->record(new UserWasCreated($name->value, $email->value));

        return $user;
    }
}
