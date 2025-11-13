<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

//INERTIA COMPLETE!!
class SessionController extends Controller
{
    public function index() : Response
    {
        return inertia('auth/Login');
    }

    public function store(LoginRequest $request) : RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'The provided credentials are incorrect.'
            ]);
        }

//        to allow testing the user logging in.
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

//        precaution
        if (!Auth::user()) {
            return back()->withErrors([
                'error' => 'Authentication failed after login. Please try again.'
            ]);
        }

        return redirect('/')
            ->with('success', "Logged In Successfully!");
    }

    public function destroy(Request $request) : RedirectResponse
    {
        Auth::guard('web')->logout(); // explicitly log out via the session-based guard

        $request->session()->invalidate();

        return redirect('/')
            ->with('message', 'Successfully logged out!');
    }
}
