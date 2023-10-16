<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserAlreadyExists;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserPasswordConfirmation;
use Src\Shared\Domain\Action\ActionValidatable;
use Src\Shared\Domain\Action\CommandAction;
use Src\Shared\Domain\Bus\Event\EventBusInterface;
use Src\Shared\Domain\Contracts\ValidationCheckContract;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class CreateUserAction extends CommandAction
{
    use ActionValidatable;

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
        private readonly ValidationCheckContract $validationChecker
    ) {
    }

    protected function handle(
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserPasswordConfirmation $password_confirmation
    ) {
        $user = $this->repository->findOneByCriteria(new Criteria(filters: [
            new Filter('email', FilterOperator::EQUAL, $email->value()),
        ]));

        if ($user !== null) {
            throw new UserAlreadyExists();
        }

        $user = User::create(
            name: $name,
            email: $email,
            password: $password
        );
        $this->repository->save($user);

        $this->eventBus->publish(...$user->pullDomainEvents());
    }
}
