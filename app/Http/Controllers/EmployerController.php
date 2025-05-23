<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

//        closure - param ($query) from outside scope for search usage
        $employers = Employer::whereHas('user', function ($userQuery) use ($query) {
            $userQuery->where('role', 'employer');

            if ($query) {
                $userQuery->where('name', 'like', "%{$query}%");
//                others orWhere(...)
            }
        })
            ->latest()
            ->simplePaginate(10)
            ->appends(['q' => $query]);

        return view('employer.index', [
            'employers' => $employers,
            'query' => $query
        ]);
    }
    public function update($id)
    {
        $employer = User::findOrFail($id);
        if(!$employer) {
            return response()->json([
                'message' => 'Could not find company.'
            ], 404);
        }

        $employer->role = 'superemployer';
        $employer->save();

        return response()->json([
            'message' => 'Employer Promoted Successfully!'
        ]);
    }

    public function destroy(string $id)
    {
        // You can now use $id to find and delete the employer
        $employer = Employer::findOrFail($id);
        $user = $employer->user;

        $employer->job()->delete();
        $user->delete();
        $employer->delete();

        return response()->json([
            'message' => 'Employer deleted successfully!'
        ]);
    }
}
