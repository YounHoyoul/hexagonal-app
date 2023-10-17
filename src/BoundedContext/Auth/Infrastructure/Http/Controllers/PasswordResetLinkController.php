<?php

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Src\BoundedContext\User\Application\Password\SendResetLinkCommand;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

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
        try {
            $this->commandBus->dispatch(new SendResetLinkCommand(
                email: $request->email
            ));
        } catch (HandlerFailedException $e) {
            throw ValidationException::withMessages([
                'email' => array_map(
                    fn (Exception $exception) => $exception->getMessage(),
                    $e->getNestedExceptions()
                ),
            ]);
        }

        return back()->with('status', __(Password::RESET_LINK_SENT));
    }
}
