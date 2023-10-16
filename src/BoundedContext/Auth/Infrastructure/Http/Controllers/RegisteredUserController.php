<?php

declare(strict_types=1);

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\BoundedContext\User\Application\Create\CreateUserCommand;
use Src\BoundedContext\User\Application\Get\GetUserByCriteriaQuery;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filter;
use Src\Shared\Domain\Criteria\FilterOperator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');

        $this->commandBus->dispatch(new CreateUserCommand(
            name: $name,
            email: $email,
            password: $password,
            password_confirmation: $password_confirmation
        ));

        $userResponse = $this->queryBus->ask(new GetUserByCriteriaQuery(new Criteria(filters: [
            new Filter('email', FilterOperator::EQUAL, $email),
            new Filter('name', FilterOperator::EQUAL, $name),
        ])));

        $user = \App\Models\User::fromDomain($userResponse);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
