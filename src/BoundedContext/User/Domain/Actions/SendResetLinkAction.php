<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\Shared\Domain\Action\ActionValidatable;
use Src\Shared\Domain\Action\CommandAction;
use Src\Shared\Domain\Contracts\ValidationCheckContract;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

final class SendResetLinkAction extends CommandAction
{
    use ActionValidatable;

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly ValidationCheckContract $validationChecker
    ) {
    }

    protected function handle(
        UserEmail $email
    ): void {
        $user = $this->repository->findOneByCriteria(new Criteria(filters:[
            new Filter('email', FilterOperator::EQUAL, $email),
        ]));

        if ($user === null) {
            throw new UserNotFound();
        }

        // $this->repository->updateProfile(
        //     $id,
        //     $name,
        //     $email,
        //     $user->email->value() != $email->value() ? null : $user->emailVerifiedDate
        // );
    }
}
