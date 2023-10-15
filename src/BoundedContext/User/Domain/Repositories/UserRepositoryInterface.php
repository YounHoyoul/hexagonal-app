<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Repositories;

use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\Users;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Criteria\Criteria;

interface UserRepositoryInterface
{
    public function find(UserId $id): ?User;

    public function findOneByCriteria(Criteria $criteria): ?User;

    public function findByCriteria(Criteria $criteria): Users;

    public function save(User $user): void;

    public function update(UserId $userId, User $user): void;

    public function updateToken(UserId $userId, UserRememberToken $token);

    public function delete(UserId $id): void;
}
