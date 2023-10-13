<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\ValueObjects;

use Src\Shared\Domain\Validation\ValidateItemInterface;
use Src\Shared\Domain\ValueObject\EmailValueObject;

final class UserEmail extends EmailValueObject implements ValidateItemInterface
{
    public function rule(): array
    {
        return [
            'required',
            'email',
        ];
    }
}
