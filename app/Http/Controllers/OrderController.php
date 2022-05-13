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
        // dd($request->order);
        if(!empty($request->order)){
            foreach ($request->order as $key => $orders) {
                if(is_object($orders)) $orders = $orders->toArray(); 
                $order = new Order();
                $order->user_id = auth()->user()->id;    
                $order->seller_id = $orders['vendor_id'];    
                $order->customer_name = $orders['customer_name'];    
                $order->email = $orders['email'];    
                $order->phone = $orders['phone'];    
                $order->area = $orders['area'];    
                $order->city = $orders['city'];    
                $order->delivery_address = $orders['delivery_address'];    
                $order->payment_type = $orders['payment_type'];    
                $order->order_date = $orders['order_date'];    
                $order->gross_amount = $orders['gross_amount'];    
                $order->tax_amount = $orders['tax_amount'];    
                $order->net_amount = $orders['net_amount'];    
                $order->shipping_amount = $orders['shipping_amount'];    
                $order->note = $orders['note'];    
                $order->save();
                if(!empty($orders['product'])){
                    foreach ($orders['product'] as $key => $product) {
                        if(is_object($product)) $product = $product->toArray(); 
                        $product_price = Product::where('id',$product['id'])->first();
                        $order_product = new OrderProduct();
                        $order_product->order_id = $order->id;
                        $order_product->product_id = $product['id'];
                        $order_product->qty = $product['qty'];
                        $order_product->subtotal = $product['qty'] * $product_price->price;
                        $order_product->discount = $product_price->discount_price * $product['qty'];
                        $order_product->save();
                    }
                }else{
                    return response()->json(['Fail'=>' Order Product Request Failed!'],500);
                }
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
