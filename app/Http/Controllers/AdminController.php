<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
//        request gets data after route
        $query = $request->input('q');
        $adminsQuery = User::where('role', 'admin');

        if($query) {
            $adminsQuery->where('name', 'like', "%$query%");
        }

        $admins = $adminsQuery
            ->latest()
            ->simplePaginate(10)
            ->appends(['q' => $query]);

        return view('admin.index',[
            'admins' => $admins,
            'query' => $query
        ]);
    }

    public function update(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if(!$user) {
                return response()->json([
                    'message' => 'Could not find user.'
                ], 404);
            }
            $user->role = 'user';
            $user->save();

            DB::commit();

            return response()->json([
                'message' => "Admin Demoted Successfully!"
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => "Could not demote admin. Error : " . $e
            ]);
        }
    }
}
