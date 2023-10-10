<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Criteria;

class Filter
{
    public function __construct(
        public readonly string $field,
        public readonly FilterOperator $operator,
        public readonly mixed $value
    ) {
    }
}
