<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Get;

use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Bus\Query\QueryInterface;
use Src\Shared\Domain\Validation\ValidateInterface;

final class GetUserByIdQuery implements QueryInterface, ValidateInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }

    public function rules(): array
    {
        return [
            'id' => UserId::rule(),
        ];
    }
}
