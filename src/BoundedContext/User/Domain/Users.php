<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain;

use Src\Shared\Domain\AbstractCollection;

final class Users extends AbstractCollection
{
    protected function type(): string
    {
        return User::class;
    }
}
