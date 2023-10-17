<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\TokenNotFound;
use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Repositories\TokenRepositoryInterface;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserPasswordConfirmation;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;
use Src\Shared\Domain\Action\CommandAction;

class ResetPasswordAction extends CommandAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly TokenRepositoryInterface $tokenRepository
    ) {
    }

    protected function handle(
        ResetToken $token,
        UserEmail $email,
        UserPassword $password,
        UserPasswordConfirmation $password_confirmation
    ): void {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new UserNotFound();
        }

        if ($this->tokenRepository->exists($email, $token)) {
            throw new TokenNotFound();
        }

        $this->userRepository->updatePassword($user->id, $password);

        $this->userRepository->updateToken(
            $user->id,
            UserRememberToken::fromValue(bin2hex(random_bytes(16)))
        );

        $this->tokenRepository->delete($email);
    }
}
