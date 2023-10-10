<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application;

use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\Users;
use Src\Shared\Domain\Bus\Query\ResponseInterface;

final class UsersResponse implements ResponseInterface
{
    /**
     * @param  array<UserResponse>  $users
     */
    public function __construct(private array $users)
    {
    }

    public static function fromUsers(Users $users): self
    {
        $boardResponses = array_map(
            function (User $user) {
                return UserResponse::fromUser($user);
            },
            $users->all()
        );

        return new self($boardResponses);
    }

    public function jsonSerialize(): array
    {
        return array_map(function (UserResponse $userResponse) {
            return $userResponse->jsonSerialize();
        }, $this->users);
    }
}
