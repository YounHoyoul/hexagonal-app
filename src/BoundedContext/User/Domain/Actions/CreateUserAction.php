<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserAlreadyExists;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Bus\Event\EventBusInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CreateUserAction
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
    ): void {

        $user = $this->repository->findOneByCriteria(new Criteria(filters: [
            new Filter('email', FilterOperator::EQUAL, $userEmail->value()),
            new Filter('name', FilterOperator::EQUAL, $userName->value()),
        ]));

        if ($user !== null) {
            throw new UserAlreadyExists();
        }

        $user = User::create(
            name: $userName,
            email: $userEmail,
            password: $userPassword,
            emailVerifiedDate: UserEmailVerifiedDate::fromValue(null),
            rememberToken: UserRememberToken::fromValue(null)
        );
        $this->repository->save($user);

        $this->eventBus->publish(...$user->pullDomainEvents());
    }
}
