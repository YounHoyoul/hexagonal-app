<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Create;

use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\Shared\Domain\Bus\Command\CommandInterface;
use Src\Shared\Domain\Validation\ValidateInterface;

final class CreateUserCommand implements CommandInterface, ValidateInterface
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $password
    ) {
    }

    public function rules(): array
    {
        return [
            'name' => UserName::rule(),
            'email' => UserEmail::rule(),
            'password' => UserPassword::rule(),
        ];
    }
}
