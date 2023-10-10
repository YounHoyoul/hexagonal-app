<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\Users;
use Src\Shared\Domain\Criteria\Criteria;

final class SearchUsersAction
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function __invoke(Criteria $criteria): Users
    {
        $users = $this->repository->findByCriteria($criteria);

        return $users;
    }
}
