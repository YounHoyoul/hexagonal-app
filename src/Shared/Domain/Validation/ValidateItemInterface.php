<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Validation;

interface ValidateItemInterface
{
    public static function rule(): array|string;
}
