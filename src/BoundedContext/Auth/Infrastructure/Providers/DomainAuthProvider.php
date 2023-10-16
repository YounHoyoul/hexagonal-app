<?php

namespace Src\BoundedContext\Auth\Infrastructure\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQuery;
use Src\BoundedContext\User\Application\Get\GetUserByIdQuery;
use Src\BoundedContext\User\Application\Update\UpdateUserTokenCommand;
use Src\BoundedContext\User\Domain\Exceptions\UserNotFound;
use Src\Shared\Domain\Bus\Command\CommandBusInterface;
use Src\Shared\Domain\Bus\Query\QueryBusInterface;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class DomainAuthProvider implements UserProvider
{
    public function __construct(
        private readonly HasherContract $hasher,
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus
    ) {
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return User::fromDomain(
            $this->queryBus->ask(new GetUserByIdQuery($identifier))
        );
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return User::fromDomain(
            $this->queryBus->ask(new GetUserByCriteriaQuery(new Criteria(filters: [
                new Filter('id', FilterOperator::EQUAL, $identifier),
                new Filter('remember_token', FilterOperator::EQUAL, $token),
            ])))
        );
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->commandBus->dispatch(new UpdateUserTokenCommand(
            id: $user->getAuthIdentifier(),
            token: $token
        ));
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        try {
            $userResponse = $this->queryBus->ask(new GetUserByCriteriaQuery(new Criteria(filters: [
                new Filter('email', FilterOperator::EQUAL, $credentials['email']),
            ])));

            $user = User::fromDomain($userResponse);

            if ($this->validateCredentials($user, $credentials)) {
                return $user;
            }
        } catch (HandlerFailedException $e) {
            if (empty($e->getNestedExceptionOfClass(UserNotFound::class))) {
                throw $e;
            }
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
