<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Contracts;

interface ValidationCheckContract
{
    public function pass(array $data, array $rules);
}
