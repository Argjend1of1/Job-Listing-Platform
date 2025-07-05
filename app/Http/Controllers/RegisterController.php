<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\String_;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register', ["categories" => Category::all()]);
    }
    public function store(RegisterRequest $request)
    {
        try {
            $userAttributes = $request->validated();

            $logoPath = $request->file('logo')->store('logos'); // Store the file
            $category = Category::where('name', $userAttributes['category'])->first();

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
                $user = User::create($userTableAttributes);
            }

            return response()->json([
                'message' => 'Successfully Registered!',
                'user' => $user,
                'employer' => $user->employer ?? null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() ?? 'User already exists!'
            ], 409);
        }
    }
}
