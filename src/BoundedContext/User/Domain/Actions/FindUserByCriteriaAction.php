<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\Shared\Domain\Action\QueryActionInterface;
use Src\Shared\Domain\Criteria\Criteria;

final class FindUserByCriteriaAction implements QueryActionInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(Criteria $criteria): User
    {
        $user = $this->repository->findOneByCriteria($criteria);

        if ($user === null) {
            throw new UserNotFound();
        }

        return $user;
    }
}
