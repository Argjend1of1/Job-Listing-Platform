<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $userAttributes = $request->validated();

            $logoPath = $request->file('logo')->store('logos'); // Store the file

            $userTableAttributes = [
                'name' => $userAttributes['name'],
                'email' => $userAttributes['email'],
                'password' => bcrypt($userAttributes['password']),
                'logo' => $logoPath
            ];

            // Check if the 'employer' field is provided
            if ($userAttributes['employer'] !== null) {
                if (empty($userAttributes['category'])) {
                    return response()->json([
                        'message' => 'A company must belong to a category.'
                    ], 422);
                }

                $category = Category::where('name', $userAttributes['category'])->first();
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

            DB::commit();

            return response()->json([
                'message' => 'Successfully Registered!',
                'user' => $user,
                'employer' => $user->employer ?? null
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage() ?? 'User already exists!'
            ], 500);
        }
    }
}
