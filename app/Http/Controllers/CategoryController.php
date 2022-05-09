<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show()
    {
        $category = Category::has('subCategory')->with('subCategory')->get();
       return response()->json(['Category'=>CategoryResource::collection($category)],200);

    }
}
