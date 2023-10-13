<?php

namespace Src\Shared\Infrastructure;

use Illuminate\Support\Facades\Validator;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

final class ValidationChecker implements ValidationCheckContract
{
    public function pass(array $data, array $rules): bool
    {
        Validator::make($data, $rules)->validate();

        return true;
    }
}
