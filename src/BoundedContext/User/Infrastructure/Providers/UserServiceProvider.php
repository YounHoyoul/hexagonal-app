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
use Src\BoundedContext\User\Domain\Repositories\UserRepositoryInterface;
use Src\BoundedContext\User\Infrastructure\Repositories\EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->tag(
            CreateUserCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            DeleteUserCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            UpdateUserCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            GetUserByCriteriaQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            GetUserByIdQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            SearchUsersQueryHandler::class,
            'query_handler'
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
