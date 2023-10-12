<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Action\CommandActionInterface;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

final class DeleteUserAction implements CommandActionInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly ValidationCheckContract $validationChecker
    ) {
    }

    public function __invoke(UserId $id): void
    {
        $this->validationChecker->pass([
            'id' => $id->value(),
        ], [
            'id' => UserId::rule(),
        ]);

        $user = $this->repository->find($id);

        if ($user === null) {
            throw new UserNotFound();
        }

        $this->repository->delete($id);
    }
}
