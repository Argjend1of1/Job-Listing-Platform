<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($name) {
        $category = Category::where('name', $name)->first();
        $jobs = $category->job()->simplePaginate(12);

        return view('category.index', [
            'jobs' => $jobs,
            'category' => $category
        ]);
    }
}
