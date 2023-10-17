<?php

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;
use Src\BoundedContext\User\Application\Password\SendResetLinkCommand;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->commandBus->dispatch(new SendResetLinkCommand(
            email: $request->email
        ));

        return back()->with('status', __(Password::RESET_LINK_SENT));
    }
}
