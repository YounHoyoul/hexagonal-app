<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Repositories;

use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;

interface TokenRepositoryInterface
{
    /**
     * Create a new token.
     *
     * @return string
     */
    public function create(UserEmail $email);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function exists(UserEmail $email, ResetToken $token);

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @return bool
     */
    public function recentlyCreatedToken(UserEmail $email);

    /**
     * Delete a token record.
     *
     * @return void
     */
    public function delete(UserEmail $email);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired();
}
