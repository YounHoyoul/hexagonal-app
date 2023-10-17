<?php

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;
use Src\BoundedContext\User\Application\Password\ResetPasswordCommand;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->commandBus->dispatch(new ResetPasswordCommand(
            token: $request->token,
            email: $request->email,
            password: $request->password,
            password_confirmation: $request->password_confirmation
        ));

        return redirect()->route('login')->with('status', __(Password::PASSWORD_RESET));
    }
}
