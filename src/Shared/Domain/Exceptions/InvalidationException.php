<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Exceptions;

use Src\Shared\Domain\DomainException;
use Throwable;

class InvalidationException extends DomainException
{
    private string $field;

    public function __construct($field = '', $message = '', $code = 422, Throwable $previous = null)
    {
        $this->field = $field;

        parent::__construct($message, $code, $previous);
    }

    public function getField()
    {
        return $this->field;
    }
}
