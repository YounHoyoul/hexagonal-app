<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Notifications;

use App\Models\User;
use Src\BoundedContext\User\Domain\Notifications\PasswordResetNotificationInterface;
use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;

class PasswordResetNotification implements PasswordResetNotificationInterface
{
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification(UserId $id, ResetToken $token)
    {
        $user = User::find($id->value());

        $user->sendPasswordResetNotification($token->value());
    }
}
