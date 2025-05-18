<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;

class PremiumEmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $premiumEmployers = Employer::whereHas('user', function ($q) use ($query) {
            $q->where('role', 'superemployer');

            if($query) {
                $q->where('name', 'like', "%$query%");
            }
        })
            ->latest()
            ->simplePaginate(10)
            ->appends(['q' => $query]);

        return view('employer.index-premium', [
            'employers' => $premiumEmployers,
            'query' => $query
        ]);
    }

    public function update(Request $request, string $id)
    {
        $employer = User::findOrFail($id);
        if(!$employer) {
            return response()->json([
                'message' => 'Could not find the user. Please refresh and try again!'
            ], 404);
        }

        $employer->role = 'employer';
        $employer->save();

        return response()->json([
            'message' => 'User Demoted Successfully!'
        ]);
    }

}
