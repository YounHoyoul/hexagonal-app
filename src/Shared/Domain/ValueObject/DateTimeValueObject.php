<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;

abstract class DateTimeValueObject
{
    public function __construct(public readonly ?DateTime $value)
    {
    }

    public static function fromValue(?DateTime $value)
    {
        return new static($value);
    }

    public function value(): ?DateTime
    {
        return $this->value;
    }
}
