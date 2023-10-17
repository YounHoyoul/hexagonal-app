<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Providers;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Auth\Passwords\TokenRepositoryInterface as PasswordsTokenRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Src\BoundedContext\User\Application\Create\CreateUserCommandHandler;
use Src\BoundedContext\User\Application\Delete\DeleteUserCommandHandler;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQueryHandler;
use Src\BoundedContext\User\Application\Get\GetUserByIdQueryHandler;
use Src\BoundedContext\User\Application\Listing\SearchUsersQueryHandler;
use Src\BoundedContext\User\Application\Password\ResetPasswordCommandHandler;
use Src\BoundedContext\User\Application\Password\SendResetLinkCommandHandler;
use Src\BoundedContext\User\Application\Password\UpdatePasswordCommandHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserCommandHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserProfileCommandHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserTokenCommandHandler;
use Src\BoundedContext\User\Domain\Notifications\PasswordResetNotificationInterface;
use Src\BoundedContext\User\Domain\Repositories\TokenRepositoryInterface as DomainTokenRepositoryInterface;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Infrastructure\Notifications\PasswordResetNotification;
use Src\BoundedContext\User\Infrastructure\Repositories\EloquentTokenRepository;
use Src\BoundedContext\User\Infrastructure\Repositories\EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{
    private $commandHandlers = [
        CreateUserCommandHandler::class,
        DeleteUserCommandHandler::class,
        UpdateUserCommandHandler::class,
        UpdateUserProfileCommandHandler::class,
        UpdateUserTokenCommandHandler::class,
        SendResetLinkCommandHandler::class,
        UpdatePasswordCommandHandler::class,
        ResetPasswordCommandHandler::class,
    ];

    private $queryHandlers = [
        GetUserByCriteriaQueryHandler::class,
        GetUserByIdQueryHandler::class,
        SearchUsersQueryHandler::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class,
        );

        $this->app->bind(
            DomainTokenRepositoryInterface::class,
            EloquentTokenRepository::class
        );

        $this->app->bind(
            PasswordsTokenRepositoryInterface::class,
            function () {
                $config = config('auth.passwords.users');
                $key = $this->app['config']['app.key'];

                if (str_starts_with($key, 'base64:')) {
                    $key = base64_decode(substr($key, 7));
                }

                $connection = $config['connection'] ?? null;

                return new DatabaseTokenRepository(
                    $this->app['db']->connection($connection),
                    $this->app['hash'],
                    $config['table'],
                    $key,
                    $config['expire'],
                    $config['throttle'] ?? 0
                );
            }
        );

        $this->app->bind(
            PasswordResetNotificationInterface::class,
            PasswordResetNotification::class
        );

        array_walk(
            $this->commandHandlers,
            fn ($className) => $this->app->tag($className, 'command_handler')
        );

        array_walk(
            $this->queryHandlers,
            fn ($className) => $this->app->tag($className, 'query_handler')
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
