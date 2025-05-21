<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class PasswordResetController extends Controller
{
    public function index() {
        return view('password.index');
    }

    public function show(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = Password::createToken($user);

        return response()->json([
            'message' => 'Reset token generated.',
            'reset_url' => url("/reset-password?token={$token}&email=" . urlencode($user->email)),
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    public function edit() {
        return view('password.edit');
    }

    public function update(Request $request) {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'New password must be different from the current password.'], 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful.']);
        }

        return response()->json(['message' => __($status)], 400);
    }
}
