<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

//InertiaComplete
class AdminController extends Controller
{
    public function index(Request $request): Response
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

    public function update(User $admin): RedirectResponse
    {
        $admin->update([
            'role' => 'user'
        ]);

        return back()->with(
            'message', "Admin Demoted Successfully!"
        );
    }
}
