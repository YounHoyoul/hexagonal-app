<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class IntValueObject
{
    public function __construct(public readonly int $value)
    {
        $this->validate($this->value);
    }

    public static function fromValue(int $value)
    {
        return new static($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(int $id): void
    {
        $options = [
            'options' => [
                'min_range' => 1,
            ],
        ];

        if (! filter_var($id, FILTER_VALIDATE_INT, $options)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', self::class, $id)
            );
        }
    }
}
