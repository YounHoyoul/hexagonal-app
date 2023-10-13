<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Validation;

interface ValidateItemInterface
{
    public function rule(): array|string|object;
}
