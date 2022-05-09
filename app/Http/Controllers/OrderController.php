<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrderController extends Controller
{
    public function review(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'product'=>'required',
            'order'=>'nullable',
            'star'=>'required',
            'review'=>'required',
        ]);

        if($valid->fails()){
            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        $review = new Review(); 
        $review->user_id = auth()->user()->id;
        $review->product_id = $request->product;
        $review->order_id = $request->order;
        $review->star = $request->star;
        $review->review = $request->review;
        $review->save();
        return response()->json(['Successfull'=>'New Review Added Successfully!'],200);

    }
    
    public function rating()
    {
        $rating = Review::with('products')->where('user_id',auth()->user()->id)->groupBy('product_id')
        ->select('product_id',DB::raw('sum(star) AS star'))->get();
                return response()->json(['rating'=>$rating],200);
    }
    
    public function sales()
    {
        $sales = Order::where('user_id',auth()->user()->id)
        ->select(DB::raw('sum(total) AS total'))->get();
                return response()->json(['sales'=>$sales],200);
    }
}
