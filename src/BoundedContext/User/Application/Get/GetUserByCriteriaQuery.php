<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Get;

use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\Shared\Domain\Bus\Query\QueryInterface;
use Src\Shared\Domain\Validation\ValidateInterface;

final class GetUserByCriteriaQuery implements QueryInterface, ValidateInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $name
    ) {
    }

    public function rules(): array
    {
        return [
            'name' => UserName::rule(),
            'email' => UserEmail::rule(),
        ];
    }
}
