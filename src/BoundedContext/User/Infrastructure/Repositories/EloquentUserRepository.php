<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Repositories;

use App\Models\User as EloquentModel;
use Illuminate\Support\Facades\Hash;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\Users;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;
use Src\Shared\Infrastructure\Eloquent\EloquentCriteriaTransformer;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly EloquentModel $eloquentModel)
    {
    }

    public function find(UserId $id): ?User
    {
        $user = $this->eloquentModel->find($id->value());

        if ($user === null) {
            return null;
        }

        return $user->toDomain();
    }

    public function findOneByCriteria(Criteria $criteria): ?User
    {
        $user = (new EloquentCriteriaTransformer($criteria, $this->eloquentModel))
            ->builder()
            ->first();

        if ($user === null) {
            return null;
        }

        return $user->toDomain();
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $user = (new EloquentCriteriaTransformer(new Criteria(filters: [
            new Filter('email', FilterOperator::EQUAL, $email->value()),
        ]), $this->eloquentModel))
            ->builder()
            ->first();

        if ($user === null) {
            return null;
        }

        return $user->toDomain();
    }

    public function findByCriteria(Criteria $criteria): Users
    {
        $eloquentUsers = (new EloquentCriteriaTransformer($criteria, $this->eloquentModel))
            ->builder()
            ->get();

        $users = $eloquentUsers->map(
            function (EloquentModel $eloquentUser) {
                return $eloquentUser->toDomain();
            }
        )->toArray();

        return new Users($users);
    }

    public function save(User $user): void
    {
        $newUser = $this->eloquentModel;

        $data = [
            'name' => $user->name->value(),
            'email' => $user->email->value(),
            'email_verified_at' => $user->emailVerifiedDate?->value(),
            'password' => Hash::make($user->password->value()),
            'remember_token' => $user->rememberToken?->value(),
        ];

        $newUser->create($data);
    }

    public function update(UserId $id, User $user): void
    {
        $userToUpdate = $this->eloquentModel;

        $data = [
            'name' => $user->name->value(),
            'email' => $user->email->value(),
        ];

        if ($user->password?->value()) {
            $data['password'] = Hash::make($user->password->value());
        }

        if ($user->emailVerifiedDate?->value()) {
            $data['email_verified_at'] = $user->emailVerifiedDate->value();
        }

        if ($user->rememberToken?->value()) {
            $data['remember_token'] = $user->rememberToken->value();
        }

        $userToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function updateToken(UserId $id, UserRememberToken $token): void
    {
        $userToUpdate = $this->eloquentModel;

        $data = [
            'remember_token' => $token->value(),
        ];

        $userToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function updatePassword(UserId $id, UserPassword $password): void
    {
        $userToUpdate = $this->eloquentModel;

        $data = [
            'password' => Hash::make($password->value()),
        ];

        $userToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function updateProfile(
        UserId $id,
        UserName $name,
        UserEmail $email,
        ?UserEmailVerifiedDate $emailVerifiedDate): void
    {
        $user = $this->eloquentModel->findOrFail($id->value());

        $user->name = $name->value();
        $user->email = $email->value();
        $user->email_verified_at = $emailVerifiedDate?->value();

        $user->save();
    }

    public function delete(UserId $id): void
    {
        $this->eloquentModel
            ->findOrFail($id->value())
            ->delete();
    }
}
