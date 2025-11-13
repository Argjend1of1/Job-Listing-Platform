<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

//InertiaComplete
class AdminController extends Controller
{
    public function index(Request $request)
    {
        [
            'users' => $admins,
            'query' => $query
        ] = UserService::getUsersByRole($request, 'admin');

        return inertia('admin/Index',[
            'admins' => Inertia::scroll(fn () => $admins),
            'query' => $query ?? '',
        ]);
    }

    public function update(string $id)
    {
        try {
            /** @var User $user */
            $user = User::findOrFail($id);
            if(!$user) {
                return back()->with([
                    'error', 'Could not find user.'
                ]);
            }
            $user->role = 'user';
            $user->save();

            return back()->with([
                'message' => "Admin Demoted Successfully!"
            ]);

        }catch (\Exception $e) {
            Log::error('Could not demote user', [
                'user' => $user,
                'error' => $e->getMessage(),
            ]);

            return back()->with([
                'error' => "Something unexpected happened. Please try again."
            ]);
        }
    }
}
