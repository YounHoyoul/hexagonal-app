<?php

namespace Src\BoundedContext\Auth\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Src\BoundedContext\User\Application\Delete\DeleteUserCommand;
use Src\BoundedContext\User\Application\Update\UpdateUserProfileCommand;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $this->commandBus->dispatch(new UpdateUserProfileCommand(
            id: $request->user()->id,
            name: $request->name,
            email: $request->email
        ));

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->commandBus->dispatch(new DeleteUserCommand(
            id: $request->user()->id,
            password: $request->password,
            callback: function () use ($request) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        ));

        return Redirect::to('/');
    }
}
