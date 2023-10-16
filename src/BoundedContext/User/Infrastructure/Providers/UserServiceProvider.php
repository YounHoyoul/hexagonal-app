<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BoundedContext\User\Application\Create\CreateUserCommandHandler;
use Src\BoundedContext\User\Application\Delete\DeleteUserCommandHandler;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQueryHandler;
use Src\BoundedContext\User\Application\Get\GetUserByIdQueryHandler;
use Src\BoundedContext\User\Application\Listing\SearchUsersQueryHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserCommandHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserProfileCommandHandler;
use Src\BoundedContext\User\Application\Update\UpdateUserTokenCommandHandler;
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Infrastructure\Repositories\EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{
    private $commandHandlers = [
        CreateUserCommandHandler::class,
        DeleteUserCommandHandler::class,
        UpdateUserCommandHandler::class,
        UpdateUserProfileCommandHandler::class,
        UpdateUserTokenCommandHandler::class
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
