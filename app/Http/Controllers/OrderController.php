<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;    
        $order->customer_name = auth()->user()->id;    
        $order->email = $request->email;    
        $order->phone = $request->phone;    
        $order->area = $request->area;    
        $order->city = $request->city;    
        $order->delivery_address = $request->delivery_address;    
        $order->order_date = $request->order_date;    
        $order->gross_amount = $request->gross_amount;    
        $order->tax_amount = $request->tax_amount;    
        $order->net_amount = $request->net_amount;    
        // $order->status = $request->status;    
        $order->note = $request->note;    
        if($order->save()){
            foreach ($request->product as $key => $product) {
                $product_price = Product::where('id',$product->id)->first();
                $order_product = new OrderProduct();
                $order_product->order_id = $order->id;
                $order_product->product_id = $product->id;
                $order_product->subtotal = $product->qty * $product_price->price;
                $order_product->discount = $product->qty * ($product_price->price - $product_price->discount);
                $order_product->qty = $request->qty;
                $order_product->save();
            }
            return response()->json(['Successfull'=>'New Order Request Successfully sent!'],200);
        }else{
            return response()->json(['Fail'=>'Order Request Failed!'],500);
        }
    }
    
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
