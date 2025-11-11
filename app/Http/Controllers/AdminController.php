<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

//InertiaComplete
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $adminsQuery = User::where('role', 'admin');

        if($query) {
            $adminsQuery->where('name', 'like', "%$query%");
        }

        $admins = $adminsQuery->latest();

        return inertia('admin/Index',[
            'admins' => Inertia::scroll(fn () => $admins->paginate(12)),
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
