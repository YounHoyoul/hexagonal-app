<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application\Get;

use Src\BoundedContext\User\Application\UserResponse;
use Src\BoundedContext\User\Domain\Actions\FindUserAction;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetUserByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly FindUserAction $action
    ) {
    }

    public function __invoke(GetUserByIdQuery $query): UserResponse
    {
        $user = $this->action->__invoke(
            UserId::fromValue($query->id)
        );

        return UserResponse::fromUser($user);
    }
}
