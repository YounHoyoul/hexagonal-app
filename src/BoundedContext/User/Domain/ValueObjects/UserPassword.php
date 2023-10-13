<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\ValueObjects;

use Src\Shared\Domain\Validation\ValidateItemInterface;
use Src\Shared\Domain\ValueObject\StringValueObject;

final class UserPassword extends StringValueObject implements ValidateItemInterface
{
    public function rule(): array
    {
        return [
            'required',
            'string',
            'min:3',
        ];
    }
}
