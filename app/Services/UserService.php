<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService {
    public static function getUsersByRole(Request $request, string $role) : array
    {
        $searchQuery = $request->input('q');
        $users = User::where('role', $role);

        if($searchQuery) {
            $users->where('name', 'like', "%$searchQuery%");
        }

        return [
            'users' => $users->latest()->paginate(12),
            'query' => $searchQuery,
        ];
    }
}
