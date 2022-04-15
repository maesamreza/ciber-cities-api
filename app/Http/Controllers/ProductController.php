<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
       $all_product = Product::all();

       return response()->json([$all_product],200);
    }

    public function add()
    {
        $new_product = 
    }
}
