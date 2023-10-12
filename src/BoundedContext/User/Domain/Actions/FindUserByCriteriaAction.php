<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\Shared\Domain\Action\QueryActionInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class FindUserByCriteriaAction implements QueryActionInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(UserName $name, UserEmail $email): User
    {
        $user = $this->repository->findOneByCriteria(new Criteria(filters: [
            new Filter('email', FilterOperator::EQUAL, $email->value()),
            new Filter('name', FilterOperator::EQUAL, $name->value()),
        ]));

        if ($user === null) {
            throw new UserNotFound();
        }

        return $user;
    }
}
