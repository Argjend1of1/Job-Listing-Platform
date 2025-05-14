<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
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

//                $category = Category::where('name', $userAttributes['category'])->first();
                $userTableAttributes['role'] = 'employer';

                $user = User::create($userTableAttributes);
                // Create the employer record
                $user->employer()->create([
                    'name' => $userAttributes['employer'],
//                    'category_id' => $category->id,
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
