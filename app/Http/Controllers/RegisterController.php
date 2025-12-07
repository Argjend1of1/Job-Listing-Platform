<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function __construct(private RegisterService $service){}

    public function create()
    {
        $categories = Category::all();
        return inertia(
            'auth/Register', compact('categories')
        );
    }
    public function store(RegisterRequest $request)
    {
        $userAttributes = $request->validated();

        $user = $this->service->register(
            $userAttributes, $request->storeLogo()
        );

        Auth::login($user, true);
        event(new Registered($user));

        Log::info('User registered!', [
            'user' => $user
        ]);

        return redirect('/account')
            ->with('success', 'Registered Successfully!');
    }
}
