<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\String_;

//INERTIA COMPLETE!!
class RegisterController extends Controller
{
    public function create()
    {
//        return view('auth.register', ["categories" => Category::all()]);
        $categories = Category::all();
        return inertia(
            'auth/Register', compact('categories')
        );
    }
    public function store(RegisterRequest $request)
    {
        try {
            $userAttributes = $request->validated();

            $logoPath = $request->file('logo')
                                ->store('logos', 'public');

            $category = Category::where('name', $userAttributes['category'])
                                ->first();

            $userTableAttributes = [
                'name' => $userAttributes['name'],
                'category_id' => $category->id,
                'email' => $userAttributes['email'],
                'password' => bcrypt($userAttributes['password']),
                'logo' => $logoPath
            ];

            // Check if the 'employer' field is provided
            if ($userAttributes['employer'] !== null) {
                $userTableAttributes['role'] = 'employer';

                $user = User::create($userTableAttributes);
                // Create the employer record
                $user->employer()->create([
                    'name' => $userAttributes['employer'],
                    'category_id' => $category->id,
                ]);
            }else {
                User::create($userTableAttributes);
            }

            return redirect('/login')
                ->with('success', 'Registered Successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(
                'error', $e->getMessage() ?? 'User already exists!'
            );
        }
    }
}
