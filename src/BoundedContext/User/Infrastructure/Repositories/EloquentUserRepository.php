<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Repositories;

use App\Models\User as EloquentModel;
use Illuminate\Support\Facades\Hash;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\Users;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;
use Src\Shared\Domain\Criteria\Criteria;
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

        return $this->toDomain($user);
    }

    public function findOneByCriteria(Criteria $criteria): ?User
    {
        $user = (new EloquentCriteriaTransformer($criteria, $this->eloquentModel))
            ->builder()
            ->first();

        if ($user === null) {
            return null;
        }

        return $this->toDomain($user);
    }

    public function findByCriteria(Criteria $criteria): Users
    {
        $eloquentUsers = (new EloquentCriteriaTransformer($criteria, $this->eloquentModel))
            ->builder()
            ->get();

        $users = $eloquentUsers->map(
            function (EloquentModel $eloquentUser) {
                return $this->toDomain($eloquentUser);
            }
        )->toArray();

        return new Users($users);
    }

    private function toDomain(eloquentModel $eloquentModel): User
    {
        return User::fromPrimitives(
            id: $eloquentModel->id,
            name: $eloquentModel->name,
            email: $eloquentModel->email
        );
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

        $userToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function delete(UserId $id): void
    {
        $this->eloquentModel
            ->findOrFail($id->value())
            ->delete();
    }
}
