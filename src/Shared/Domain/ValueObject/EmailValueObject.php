<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class EmailValueObject extends StringValueObject
{
    /**
     * UserEmail constructor.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(public readonly ?string $value)
    {
        $this->validate($this->value);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(?string $email): void
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the invalid email: <%s>.', self::class, $email)
            );
        }
    }
}
