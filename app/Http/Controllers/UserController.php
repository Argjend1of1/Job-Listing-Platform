<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $usersQuery = User::where('role', 'user');

        if($query) {
            $usersQuery->where('name', 'like', "%$query%");
        }

        $users = $usersQuery
            ->latest()
            ->simplePaginate(12)
            ->appends(['q' => $query]);

        return view('user.index',[
            'users' => $users,
            'query' => $query
        ]);
    }

    public function update(Request $request, User $user)
    {
        if(!$user) {
            return response()->json([
                'message' => 'Could not find user. Please refresht and try again!'
            ], 404);
        }

        // Optionally check if the user is already an admin
        if ($user->role === 'admin') {
            return response()->json(['message' => 'User is already an admin.'], 400);
        }

        $user->role = $request->input('role', 'admin'); // default to 'admin' if role not sent
        $user->save();

        return response()->json([
            'message' => 'User promoted successfully!',
            'user' => $user
        ]);
    }
}
