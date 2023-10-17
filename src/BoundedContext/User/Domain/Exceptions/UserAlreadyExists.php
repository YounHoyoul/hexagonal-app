<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\InvalidationException;
use Throwable;

final class UserAlreadyExists extends InvalidationException
{
    public function __construct($field = '', $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $field === '' ? 'email' : $field,
            $message === '' ? 'Token was already created' : $message,
            $code,
            $previous
        );
    }
}
