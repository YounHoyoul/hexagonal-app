<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;

final class DeleteUserAction
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function __invoke(UserId $userId): void
    {
        $user = $this->repository->find($userId);

        if ($user === null) {
            throw new UserNotFound();
        }

        $this->repository->delete($userId);
    }
}
