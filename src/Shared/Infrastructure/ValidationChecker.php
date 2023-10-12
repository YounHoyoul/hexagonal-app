<?php

namespace Src\Shared\Infrastructure;

use Illuminate\Support\Facades\Validator;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

final class validationChecker implements ValidationCheckContract
{
    public function pass(array $data, array $rules)
    {
        Validator::make($data, $rules)->validate();
    }
}
