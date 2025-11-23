<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    public function index(): Response
    {
        return inertia('password/Index');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? redirect('/forgot-password/email-sent')->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function wait(): Response
    {
        return inertia('password/Wait');
    }

    public function edit(Request $request, string $token): Response
    {
        return inertia('password/Edit', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect('/login')->with('message', 'Password reset was successful!')
            : back()->withErrors(['error' => [__($status)]]);
    }
}
