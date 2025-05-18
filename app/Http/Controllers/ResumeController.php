<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('resume.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:4096'
        ]);

//        Store privately in storage/app/resumes
        $path = $request->file('resume')->store('resumes', 'local');
        $user = Auth::user();

//        Delete old resume if it exists
        if($user->resume) {
//            locally
            Storage::disk('local')->delete($user->resume->file_path);

//            database:
            $user->resume->delete();
        }

        Resume::create([
            'user_id' => Auth::user()->id,
            'file_path' => $path,
        ]);

        return response()->json([
            'message' => 'Resume Uploaded Successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

}
