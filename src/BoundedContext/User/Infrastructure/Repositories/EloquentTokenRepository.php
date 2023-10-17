<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Repositories;

use App\Models\User as EloquentModel;
use Illuminate\Auth\Passwords\TokenRepositoryInterface as PasswordsTokenRepositoryInterface;
use Src\BoundedContext\User\Domain\Repositories\TokenRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;

final class EloquentTokenRepository implements TokenRepositoryInterface
{
    public function __construct(
        protected readonly PasswordsTokenRepositoryInterface $repository,
        private readonly EloquentModel $userModel
    ) {
    }

    /**
     * Create a new token.
     *
     * @return string
     */
    public function create(UserEmail $email)
    {
        return $this->repository->create(
            $this->userModel->where('email', $email->value())->first()
        );
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function exists(UserEmail $email, ResetToken $token)
    {
        return $this->repository->exists(
            $this->userModel->where('email', $email->value())->first(),
            $token->value()
        );
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @return bool
     */
    public function recentlyCreatedToken(UserEmail $email)
    {
        return $this->repository->recentlyCreatedToken(
            $this->userModel->where('email', $email->value())->first()
        );
    }

    /**
     * Delete a token record.
     *
     * @return void
     */
    public function delete(UserEmail $email)
    {
        $this->repository->delete(
            $this->userModel->where('email', $email->value())->first()
        );
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $this->repository->deleteExpired();
    }
}
