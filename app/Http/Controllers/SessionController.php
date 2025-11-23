<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        if (!Auth::attempt($request->validated())) {
            return back()->withErrors([
                'password' => 'The provided credentials are incorrect.'
            ]);
        }

        /**
         * Rehash password if algorithm or cost changed
         *
         * @var User $user
         */
        $user = Auth::user();
        if(Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

//      to allow testing the user logging in.
        $request->session()->regenerate();

        if (!Auth::user()) {
            return back()->withErrors([
                'error' => 'Authentication failed after login. Please try again.'
            ]);
        }

        return redirect('/account')
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
