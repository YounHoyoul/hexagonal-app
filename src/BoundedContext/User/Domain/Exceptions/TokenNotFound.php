<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Exceptions;

use Src\Shared\Domain\DomainException;
use Throwable;

final class TokenNotFound extends DomainException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? 'Token not found' : $message;

        parent::__construct($message, $code, $previous);
    }
}
