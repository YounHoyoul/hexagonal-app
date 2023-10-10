<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Criteria;

class Criteria
{
    /**
     * @param  Filter[]|null  $filters
     * @param  Order[]|null  $orderList
     */
    public function __construct(
        public readonly ?array $filters = null,
        public readonly ?array $orderList = null,
        public readonly ?int $offset = null,
        public readonly ?int $limit = null
    ) {
    }
}
