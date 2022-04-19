<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductsResource;
use Validator;
class ProductController extends Controller
{
    public function show()
    {
       $all_product = Product::all();

       return response()->json(['Products'=>ProductsResource::collection($all_product)],200);
    }

    public function add(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'title'=>'required',
            'short_description'=>'required',
            'description'=>'required',
            'price'=>'required',
            'discounted_price'=>'required',
            'images'=>'required',
            'rating'=>'required',
            'review'=>'required',
            'color'=>'required',
            'size'=>'required',
            'brand'=>'required',
            'tags'=>'required',
            'weight'=>'required',
        ]);

        if($valid->fails()){

            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        $new_product = new Product();
        $new_product->title = $request->title;
        $new_product->short_description = $request->short_description;
        $new_product->description = $request->description;
        $new_product->price = $request->price;
        $new_product->discounted_price = $request->discounted_price;
        $new_product->images = $request->images;
        $new_product->rating = $request->rating;
        $new_product->review = $request->review;
        $new_product->color = $request->color;
        $new_product->size = $request->size;
        $new_product->brand = $request->brand;
        $new_product->tags = $request->tags;
        $new_product->tags = $request->tags;
        $new_product->weight = $request->weight;
        $new_product->save();

        return response()->json(['Successfull'=>'New Product Added Successfully!'],200);
    }
}
