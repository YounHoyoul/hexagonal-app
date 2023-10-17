<?php

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Src\BoundedContext\User\Application\Password\UpdatePasswordCommand;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $this->commandBus->dispatch(new UpdatePasswordCommand(
            id: $request->user()->id,
            password: $request->password,
            current_password: $request->current_password,
            password_confirmation: $request->password_confirmation
        ));

        return back();
    }
}
