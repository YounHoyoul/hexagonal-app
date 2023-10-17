<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Actions;

use Src\BoundedContext\User\Domain\Exceptions\TokenWasAlreadyCreated;
use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\BoundedContext\User\Domain\Notifications\PasswordResetNotificationInterface;
use Src\BoundedContext\User\Domain\Repositories\TokenRepositoryInterface;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\Shared\Domain\Action\ActionValidatable;
use Src\Shared\Domain\Action\CommandAction;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

final class SendResetLinkAction extends CommandAction
{
    use ActionValidatable;

    public function __construct(
        private readonly TokenRepositoryInterface $tokenRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ValidationCheckContract $validationChecker,
        private readonly PasswordResetNotificationInterface $passwordResetNotification
    ) {
    }

    protected function handle(
        UserEmail $email
    ): void {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new UserNotFound();
        }

        if ($this->tokenRepository->recentlyCreatedToken($email)) {
            throw new TokenWasAlreadyCreated();
        }

        $token = $this->tokenRepository->create($email);

        $this->passwordResetNotification->sendPasswordResetNotification(
            $user->id,
            ResetToken::fromValue($token)
        );
    }
}
