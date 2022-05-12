<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class passportAuthController extends Controller
{
    public function registerUserExample(Request $request){
        $valid = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|Unique:users,email',
            'password'=>'required|min:8',
        ]);

        if($valid->fails()){

            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        $user= User::create([
            'role_id' =>2,
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        auth()->attempt([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        //  return auth('user')->user();
        // $access_token_example = auth('user')->user()->createToken('uhugfy')->access_token;
        //return the access token we generated in the above step
        return response()->json(['Success'=>'New User Registered Successfully!'],200);
    }

    public function registerSellerExample(Request $request){
        $valid = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|Unique:users,email',
            'password'=>'required|min:8',
            'company'=>'required',
            'phone'=>'required',
            'city'=>'required',
            'state'=>'required',
            'address'=>'required',
        ]);

        if($valid->fails()){

            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
        $user= User::create([
            'role_id' =>3,
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'company'=>$request->company,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'state'=>$request->state,
            'address'=>$request->address,

        ]);
        auth()->attempt([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        //  return auth('user')->user();
        // $access_token_example = auth('user')->user()->createToken('uhugfy')->access_token;
        //return the access token we generated in the above step
        return response()->json(['Success'=>'New Seller Registered Successfully!'],200);
    }
    /**
     * login user to our application
     */
    public function loginUserExample(Request $request){
        $this->validate($request,[
            'email'=>'required|email|Exists:users,email',
            'password'=>'required|min:8',
        ]);
        $user = User::where('email',$request->email)->whereHas('role',function ($query) {
            $query->where('name','user');
        })->get();
        if(count($user)){
            $login_credentials=[
                'email'=>$request->email,
                'password'=>$request->password,
            ];
            if(auth()->attempt($login_credentials)){
                $user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;
                return response()->json(['token' => $user_login_token,'user'=>$user], 200);
            }
            else{
                return response()->json(['error' => 'UnAuthorised Access'], 500);
            }
        }
        return response()->json(['error' => 'UnAuthorised Access'], 500);
    }

    public function loginSellerExample(Request $request){
        $this->validate($request,[
            'email'=>'required|email|Exists:users,email',
            'password'=>'required|min:8',
        ]);
        $user = User::where('email',$request->email)->whereHas('role',function ($query) {
            $query->where('name','seller');
        })->get();
        if(count($user)){
            $login_credentials=[
                'email'=>$request->email,
                'password'=>$request->password,
            ];
            if(auth()->attempt($login_credentials)){
                $user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;
                return response()->json(['token' => $user_login_token,'seller'=>$user], 200);
            }
            else{
                return response()->json(['error' => 'UnAuthorised Access'], 500);
            }
        }
        return response()->json(['error' => 'UnAuthorised Access'], 500);
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails(){
        $user = auth()->user();
        return response()->json(['authenticated-user' => $user], 200);
    }
    public function authenticatedSellerDetails(){
        $seller = auth()->user();
        return response()->json(['authenticated-seller' => $seller], 200);
    }

    public function updateSeller(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'name'=>'required',
            // 'email'=>'required|email|unique:users,email'.$seller->id,
            // 'password'=>'required|min:8',
            'company'=>'required',
            'phone'=>'required',
            'city'=>'required',
            'state'=>'required',
            'address'=>'required',
        ]);
        
        if($valid->fails()){
            
            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
            $seller = User::where('id',auth()->user()->id)->first();
            $seller->name=$request->name;
            $seller->company=$request->company;
            $seller->phone=$request->phone;
            $seller->city=$request->city;
            $seller->state=$request->state;
            $seller->address=$request->address;
        if($seller->save()){
            return response()->json(['Success'=>'Seller Updated Successfully!','seller'=>$seller??[]],200);
        }else{
            return response()->json(['fail'=>'Seller not Updated'],500);
        }
    }
}
