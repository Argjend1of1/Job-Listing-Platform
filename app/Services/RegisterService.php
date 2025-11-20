<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Query\Builder;

class RegisterService {
    public function storeUser(array $userAttributes, ?string $logoPath, Category $category): User
    {
        $validatedUserData = [
            'name' => $userAttributes['name'],
            'category_id' => $category->id,
            'email' => $userAttributes['email'],
            'password' => bcrypt($userAttributes['password']),
            'logo' => $logoPath
        ];

        return User::create($validatedUserData);
    }

    public function storeEmployer(User $user, array $userAttributes, Category $category): void
    {
        $user->employer()->create([
            'name' => $userAttributes['employer'],
            'category_id' => $category->id,
        ]);
    }

    public function register(array $userAttributes, ?string $logoPath): User
    {
        /** @var Category $category */
        $category = Category::where(
            'name', $userAttributes['category']
        )->firstOrFail();

        $user = $this->storeUser($userAttributes, $logoPath, $category);

        if(!empty($userAttributes['employer'])) {
            $user->update(['role' => 'employer']);
            $this->storeEmployer($user, $userAttributes, $category);
        }

        return $user;
    }
}
