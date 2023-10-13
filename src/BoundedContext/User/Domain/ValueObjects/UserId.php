<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\ValueObjects;

use Src\Shared\Domain\Validation\ValidateItemInterface;
use Src\Shared\Domain\ValueObject\IntValueObject;

final class UserId extends IntValueObject implements ValidateItemInterface
{
    public function rule(): array
    {
        return [
            'required',
            'integer',
        ];
    }
}
