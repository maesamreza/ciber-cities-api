<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductsResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Validator;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function show()
    {
       $all_product = Product::has('user')->with('user','images','subCategories.categories')->get();
       return response()->json(['Products'=>ProductsResource::collection($all_product)],200);
    }

    public function vendorProduct()
    {
       $all_product = Product::has('user')->with('user','images','subCategories.categories')->where('user_id',auth()->user()->id)->get();
       return response()->json(['Products'=>ProductsResource::collection($all_product)],200);
    }

    public function showProduct(Request $request)
    {
       $all_product = Product::where('id',$request->id)->has('user')->with('user','images','subCategories.categories')->get();
       return response()->json(['Products'=>ProductsResource::collection($all_product)],200);
    }

    public function add(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'product_name'=>'required',
            'price'=>'required',
            'discount'=>'required',
            'color'=>'required|array',
            'size'=>'required|array',
            'brand'=>'required',
            'product_status'=>'required',
            'product_selected_qty'=>'nullable',
            'product_stock'=>'required',
            'product_details'=>'required',
            'product_image'=>'required|array',
            'category'=>'required',
            'sub_category'=>'required',
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
            if($request->category && $request->sub_category){
                $category = Category::where('name',$request->category)->first();
                if(!is_object($category)){
                    $category = new Category();
                    $category->name = $request->category;
                    $category->url = strtolower(preg_replace('/\s*/', '', $request->category));
                    $category->save();

                    $subcategory = new SubCategory();
                    $subcategory->category_id = $category->id;
                    $subcategory->name = $request->sub_category;
                    $subcategory->url = strtolower(preg_replace('/\s*/', '', $request->category.'/'.$request->sub_category));
                    $subcategory->save();
                }else{
                    $subcategory = SubCategory::whereHas('categories',function ($query) use($request,$category) {
                        $query->where('id',$category->id);
                       })->where('name', $request->sub_category)->first();
                    if(!is_object($subcategory)){
                        $subcategory = new SubCategory();
                        $subcategory->category_id = $category->id;
                        $subcategory->name = $request->sub_category;
                        $subcategory->url = strtolower(preg_replace('/\s*/', '', $request->category.'/'.$request->sub_category));
                        $subcategory->save();
                    }
                }
                $new_product->sub_category_id = $subcategory->id;
            }
            $new_product->name = $request->product_name;
            $new_product->price = $request->price;
            $new_product->discount_price = $request->discount;
            $new_product->color = $request->color;
            $new_product->size = $request->size;
            $new_product->brand = $request->brand;
            $new_product->status = $request->product_status;
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
            if (!empty($request->product_image)){
                foreach ($request->product_image as $image) {
                    // dd($image);
                    $product_image = new ProductImage();
                    $product_image->product_id = $new_product->id;
                    $filename = "Image-" . time() . "-" . rand() . "." . $image->getClientOriginalExtension();
                    $image->storeAs('image', $filename, "public");
                    $product_image->image = "image/" . $filename;
                    $product_image->save();
                }
            }
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
   
    

    public function update(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'product_name'=>'required',
            'price'=>'required',
            'discount'=>'required',
            'color'=>'required|array',
            'size'=>'required|array',
            'brand'=>'required',
            'product_status'=>'required',
            // 'product_selected_qty'=>'nullable',
            'product_stock'=>'required',
            'product_details'=>'required',
            // 'product_image'=>'required|array',
            'category'=>'required',
            'sub_category'=>'required',
            // 'description'=>'required',
            // 'rating'=>'required',
            // 'review'=>'required',
            // 'tags'=>'required',
            // 'weight'=>'required',
        ]);

        if($valid->fails()){
            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        $product = Product::where('id', $request->id)->first();
        if(auth()->user()->role_id == 3){
            $product->user_id = auth()->user()->id;
            if($request->category && $request->sub_category){
                $category = Category::where('name',$request->category)->first();
                if(!is_object($category)){
                    $category = new Category();
                    $category->name = $request->category;
                    $category->url = strtolower(preg_replace('/\s*/', '', $request->category));
                    $category->save();

                    $subcategory = new SubCategory();
                    $subcategory->category_id = $category->id;
                    $subcategory->name = $request->sub_category;
                    $subcategory->url = strtolower(preg_replace('/\s*/', '', $request->category.'/'.$request->sub_category));
                    $subcategory->save();
                }else{
                    $subcategory = SubCategory::whereHas('categories',function ($query) use($request,$category) {
                        $query->where('id',$category->id);
                       })->where('name', $request->sub_category)->first();
                    if(!is_object($subcategory)){
                        $subcategory = new SubCategory();
                        $subcategory->category_id = $category->id;
                        $subcategory->name = $request->sub_category;
                        $subcategory->url = strtolower(preg_replace('/\s*/', '', $request->category.'/'.$request->sub_category));
                        $subcategory->save();
                    }
                }
                $product->sub_category_id = $subcategory->id;
            }
            $product->name = $request->product_name;
            $product->price = $request->price;
            $product->discount_price = $request->discount;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->brand = $request->brand;
            $product->status = $request->product_status;
            $product->stock = $request->product_stock;
            $product->details = $request->product_details;
            $product->save();
            return response()->json(['Successfull'=>'Product Updated Successfully!'],200);
        }else{
            return response()->json(['UnSuccessfull'=>'Product not Updated!'],500);
        }
    }

    public function image($id)
    {
       $all_image = ProductImage::where('product_id',$id)->get();
       return response()->json(['Images'=>$all_image],200);
    }

    public function addImage(Request $request)
    {
        if (!empty($request->product_image)){
            foreach ($request->product_image as $image) {
                $product_image = new ProductImage();
                $product_image->product_id = $request->product_id;
                $filename = "Image-" . time() . "-" . rand() . "." . $image->getClientOriginalExtension();
                $image->storeAs('image', $filename, "public");
                $product_image->image = "image/" . $filename;
                $product_image->save();
            }
            return response()->json(['Successfull'=>'Product Image Added Successfully!'],200);
        }else{
            return response()->json(['Fail'=>'Product Image not Added!'],500);
        }
    }

    public function deleteImage(Request $request)
    {
        $product = ProductImage::where('id', $request->id)->first();
        if(!empty($product)){
            if($product->delete()) return response()->json(['status'=>'successfully Image deleted'],200);
        }else{
            return response()->json(["status" => 'fail', 500]);
        }
    }

    public function delete(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if(!empty($product)){
            if($product->delete()) return response()->json(['status'=>'successfully deleted'],200);
        }else{
            return response()->json(["status" => 'fail', 500]);
        }
    }

    public function seller_totalsales_count()
    {
        $seller_totalsales_count=Order::where('seller_id',auth()->user()->id)->groupBy('seller_id')
        ->select('seller_id',DB::raw('sum(net_amount) AS net_amount'))->get();
        return response()->json(["status" => 'success','totalsales_count' => $seller_totalsales_count],200);
    }

    public function seller_products_count()
    {
        $seller_products_count=Product::where('user_id',auth()->user()->id)->count();
        $seller_category_count = Category::with(['subCategory'=>function($query){
            $query->withCount('products')->orderBy('name','DESC');
        }])->get();
        return response()->json(["status" => 'success','products_count' => $seller_products_count,
        'category_count'=>$seller_category_count],200);
    }

    public function seller_top_products()
    {
        $seller_top_products=Product::with(['orders'=>function($query){
            $query->withCount('products')->orderBy('id','desc');
        }])->get();
        return response()->json(["status" => 'success','seller_top_products' => $seller_top_products],200);
    }

}
