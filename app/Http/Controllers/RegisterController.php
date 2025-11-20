<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\RegisterService;

//INERTIA COMPLETE!!
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

        try {
            $this->service->register(
                $userAttributes, $request->storeLogo()
            );

            return redirect('/login')
                ->with('success', 'Registered Successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(
                'error', $e->getMessage() ?? 'User already exists!'
            );
        }
    }
}
