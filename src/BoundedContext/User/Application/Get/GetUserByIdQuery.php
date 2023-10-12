<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Get;

use Src\Shared\Domain\Bus\Query\QueryInterface;

final class GetUserByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
