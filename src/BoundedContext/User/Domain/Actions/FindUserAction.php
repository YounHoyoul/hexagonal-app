<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Action\QueryActionInterface;

final class FindUserAction implements QueryActionInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(UserId $userId): User
    {
        $user = $this->repository->find($userId);

        if ($user === null) {
            throw new UserNotFound();
        }

        return $user;
    }
}
