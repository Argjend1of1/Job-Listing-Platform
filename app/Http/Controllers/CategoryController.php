<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

//Inertia Complete!!
class CategoryController extends Controller
{
    public function index($name)
    {
        /** @var Category $category */
        $category = Category::where('name', $name)->first();
        $jobs = $category->job()->with(['employer', 'tags']);

        return inertia('category/Index', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'category' => $category
        ]);
    }
}
