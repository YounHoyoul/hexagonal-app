<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\InvalidationException;
use Throwable;

final class TokenWasAlreadyCreated extends InvalidationException
{
    public function __construct($field = '', $message = '', $code = 422, Throwable $previous = null)
    {
        parent::__construct(
            $field === '' ? 'token' : $field,
            $message === '' ? 'Token was already created' : $message,
            $code,
            $previous
        );
    }
}
