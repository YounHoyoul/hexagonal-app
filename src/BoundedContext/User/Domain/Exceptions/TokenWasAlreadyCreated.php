<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Exceptions;

use Src\Shared\Domain\DomainException;
use Throwable;

final class TokenWasAlreadyCreated extends DomainException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? 'Token was already created' : $message;

        parent::__construct($message, $code, $previous);
    }
}
