<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;

class PasswordResetController extends Controller
{
    public function index(): Response
    {
        return inertia('password/Index');
    }

    public function sendEmail(Request $request) : RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'error' => 'User not found. Please try again.'
            ]);
        }
        $token = Password::createToken($user);
        Mail::to($user)->queue(new PasswordReset($user, $token));

        return redirect('/forgot-password/index')->with(
            'message', "Email has been sent. Please check your email to proceed with reset.",
        );
    }



    public function edit(Request $request) : Response
    {
        return inertia('password/Edit', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['message' => 'User not found.']);
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['error' => 'New password must be different from the current password.']);
        }

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return back()->with('message', 'Password reset was successful.');
            }

        }catch (\Exception $e) {
            Log::error('Could not reset password', [
                'user' => $user,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'error' => 'Something went wrong while resetting password. Please try again.'
            ]);
        }
    }
}
