<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\Shared\Domain\Action\CommandActionInterface;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

final class UpdateUserAction implements CommandActionInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly ValidationCheckContract $validationChecker
    ) {
    }

    public function __invoke(UserId $id, UserName $name, UserEmail $email): void
    {
        $this->validationChecker->pass([
            'name' => $name->value(),
            'email' => $email->value(),
            'id' => $id->value(),
        ], [
            'name' => UserName::rule(),
            'email' => UserEmail::rule(),
            'id' => UserId::rule(),
        ]);

        $user = $this->repository->find($id);

        if ($user === null) {
            throw new UserNotFound();
        }

        $user = User::fromPrimitives(
            email: $email->value(),
            name: $name->value()
        );

        $this->repository->update($id, $user);
    }
}
