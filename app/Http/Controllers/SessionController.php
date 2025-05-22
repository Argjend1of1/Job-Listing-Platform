<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employer = Auth::user()->employer;

        return response()->json([
            'user' => $user,
            'employer' => $employer,
        ]);
    }
    public function create()
    {
        return view('auth.login');
    }
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }

//        to allow testing the user logging in.
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }
//        precaution
        if (!Auth::user()) {
            return response()->json([
                'message' => 'Authentication failed after login. Please try again.'
            ], 500);
        }

        return response()->json([
            'message' => 'Logged in successfully!',
            'user' => Auth::user()
        ]);
    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); // explicitly log out via the session-based guard

        $request->session()->invalidate();

        return response()->json([
            'message' => 'Successfully logged out!'
        ]);
    }
}
