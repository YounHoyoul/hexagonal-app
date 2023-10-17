<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Notifications;

use Src\BoundedContext\User\Domain\ValueObjects\ResetToken;
use Src\BoundedContext\User\Domain\ValueObjects\UserId;

interface PasswordResetNotificationInterface
{
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification(UserId $id, ResetToken $token);
}
