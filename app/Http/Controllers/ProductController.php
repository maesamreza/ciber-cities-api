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
       $all_product = Product::has('user')->with('user')->get();
       return response()->json(['Products'=>ProductsResource::collection($all_product)],200);
    }

    public function add(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'product_name'=>'required',
            'price'=>'required',
            'discount'=>'required',
            'product_image'=>'required',
            'color'=>'required|array',
            'size'=>'required|array',
            'brand'=>'required',
            'product_status'=>'required',
            'product_selected_qty'=>'required',
            'product_stock'=>'required',
            'product_details'=>'required',
            // 'short_description'=>'required',
            // 'description'=>'required',
            // 'rating'=>'required',
            // 'review'=>'required',
            // 'tags'=>'required',
            // 'weight'=>'required',
        ]);

        if($valid->fails()){
            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        if(auth()->user()->role_id == 3){
            $new_product = new Product();
            $new_product->user_id = auth()->user()->id;
            $new_product->name = $request->product_name;
            $new_product->price = $request->price;
            $new_product->discount_price = $request->discount;
            if (!empty($request->product_image)) {
                $file = $request->product_image;
                $filename = "Image-" . time() . "-" . rand() . "." . $file->getClientOriginalExtension();
                $file->storeAs('image', $filename, "public");
                $new_product->image = "image/" . $filename;
            } 
            $new_product->color = $request->color;
            $new_product->size = $request->size;
            $new_product->brand = $request->brand;
            $new_product->status = $request->product_status;
            $new_product->selected_qty = $request->product_selected_qty;
            $new_product->stock = $request->product_stock;
            $new_product->details = $request->product_details;
            // $new_product->short_description = $request->short_description;
            // $new_product->description = $request->description;
            // $new_product->rating = $request->rating;
            // $new_product->review = $request->review;
            // $new_product->tags = $request->tags;
            // $new_product->tags = $request->tags;
            // $new_product->weight = $request->weight;
            $new_product->save();
            return response()->json(['Successfull'=>'New Product Added Successfully!'],200);
        }else{
            return response()->json(['UnSuccessfull'=>'New Product not Added!'],500);
        }
    }

    // public function sellerAddProd(Request $request)
    // {
    //     $valid = Validator::make($request->all(),[
    //         'name'=>'required',
    //         'price'=>'required',
    //         'discount_price'=>'required',
    //         'image'=>'required',
    //         'color'=>'required|array',
    //         'size'=>'required|array',
    //         'brand'=>'required',
    //         'details'=>'required',
    //         'status'=>'required',
    //         'selected_qty'=>'required',
    //         'product_stock'=>'required',
    //         // 'short_description'=>'required',
    //         // 'description'=>'required',
    //         // 'rating'=>'required',
    //         // 'review'=>'required',
    //         // 'tags'=>'required',
    //         // 'weight'=>'required',
    //     ]);

    //     if($valid->fails()){
    //         return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
    //     }
    //     $new_product = new Product();
    //     $new_product->user_id = auth()->user()->id;
    //     $new_product->name = $request->product_name;
    //     $new_product->price = $request->price;
    //     $new_product->discount_price = $request->discount;
    //     if (!empty($request->product_image)) {
    //         $file = $request->product_image;
    //         $filename = "Image-" . time() . "-" . rand() . "." . $file->getClientOriginalExtension();
    //         $file->storeAs('image', $filename, "public");
    //         $new_product->image = "image/" . $filename;
    //     } 
    //     $new_product->color = $request->color;
    //     $new_product->size = $request->size;
    //     $new_product->brand = $request->brand;
    //     $new_product->status = $request->product_status;
    //     $new_product->selected_qty = $request->product_selected_qty;
    //     $new_product->stock = $request->product_stock;
    //     $new_product->details = $request->product_details;
    //     // $new_product->short_description = $request->short_description;
    //     // $new_product->description = $request->description;
    //     // $new_product->rating = $request->rating;
    //     // $new_product->review = $request->review;
    //     // $new_product->tags = $request->tags;
    //     // $new_product->tags = $request->tags;
    //     // $new_product->weight = $request->weight;
    //     $new_product->save();

    //     return response()->json(['Successfull'=>'New Product Added Successfully!'],200);
    // }
    public function search($name)
    {
        if (!empty($name)) {
            $product = Product::where('name','LIKE','%'.$name.'%')->get();
            if(count($product)){
                return response()->json(['Products'=>ProductsResource::collection($product)],200);
            }else{
                return response()->json(['error'=>'Product not found'],500);
            }
        }else{
            return response()->json(['error'=>'Parameter is null'],500);
        }

    }
}
