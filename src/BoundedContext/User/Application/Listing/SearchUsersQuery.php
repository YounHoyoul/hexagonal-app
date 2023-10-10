<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Listing;

use Src\Shared\Domain\Bus\Query\QueryInterface;

final class SearchUsersQuery implements QueryInterface
{
    public function __construct(
        public readonly ?array $filters = null,
        public readonly ?array $orderBy = null,
        public readonly ?string $order = null,
        public readonly ?int $offset = null,
        public readonly ?int $limit = null
    ) {
    }
}
