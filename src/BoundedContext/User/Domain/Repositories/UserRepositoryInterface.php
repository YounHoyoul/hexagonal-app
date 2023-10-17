<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Repositories;

use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\Users;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Criteria\Criteria;

interface UserRepositoryInterface
{
    public function find(UserId $id): ?User;

    public function findOneByCriteria(Criteria $criteria): ?User;

    public function findByEmail(UserEmail $userEmail): ?User;

    public function findByCriteria(Criteria $criteria): Users;

    public function save(User $user): void;

    public function update(UserId $userId, User $user): void;

    public function updateToken(UserId $userId, UserRememberToken $token): void;

    public function updatePassword(UserId $userId, UserPassword $password): void;

    public function updateProfile(UserId $userId, UserName $name, UserEmail $email, ?UserEmailVerifiedDate $emailVerifiedDate): void;

    public function delete(UserId $id): void;
}
