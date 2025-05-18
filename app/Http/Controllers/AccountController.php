<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }

    public function show()
    {
        $user = Auth::user();
        $employer = $user->employer;

        return response()->json([
            'user' => $user,
            'employer' => $employer
        ]);
    }

    public function edit()
    {
        return view('account.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if($user->employer) {
            $request->validate([
                'name'       => 'required|string|max:255',
                'employer'   => 'required|string|max:100', // if salary is in string format like "$50,000 USD"
            ]);

            $user->employer->update([
                'name' => $request->employer
            ]);
        }else {
            $request->validate([
                'name'       => 'required|string|max:255',
            ]);
        }

        $user->update([
            'name' => $request->name,
        ]);

//      send an email to the user through queues

        return response()->json([
            'message' => 'Account updated successfully.',
            'job'     => $user->fresh()->load('employer'),
        ], 200);
    }


    public function destroy()
    {
        Auth::user()->delete();

//        for users with no company relation:
        if(Auth::user()->employer) Auth::user()->employer->delete();

        return response()->json([
            'message' => 'Account deleted successfully.'
        ]);
    }
}
