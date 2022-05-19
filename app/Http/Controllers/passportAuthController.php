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
            $user = new User();
            $user->role_id = 3;
            $user->name = $request->name;
            $user->email= $request->email;
            $user->password= bcrypt($request->password);
            $user->company= $request->company;
            $user->phone= $request->phone;
            $user->city= $request->city;
            $user->state= $request->state;
            $user->address= $request->address;
            $user->save();
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

    public function loginAdminExample(Request $request){
        $this->validate($request,[
            'email'=>'required|email|Exists:users,email',
            'password'=>'required|min:8',
        ]);
        $user = User::where('email',$request->email)->whereHas('role',function ($query) {
            $query->where('name','admin');
        })->get();
        if(count($user)){
            $login_credentials=[
                'email'=>$request->email,
                'password'=>$request->password,
            ];
            if(auth()->attempt($login_credentials)){
                $user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;
                return response()->json(['token' => $user_login_token,'admin'=>$user], 200);
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

    public function userDetails(){
        $user = User::whereHas('role',function ($query) {
            $query->where('name','user');
        })->get();
        return response()->json(['user' => $user], 200);
    }

    public function sellerDetails(){
        $user = User::whereHas('role',function ($query) {
            $query->where('name','seller');
        })->get();
        return response()->json(['seller' => $user], 200);
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
    
    public function updateUser(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'name'=>'required',
            // 'company'=>'required',
            'phone'=>'nullable',
            'city'=>'nullable',
            'state'=>'nullable',
            'address'=>'nullable',
        ]);
        
        if($valid->fails()){
            
            return response()->json(['status'=>'fails','message'=>'Validation errors','errors'=>$valid->errors()]);
        }
            $user = User::where('id',auth()->user()->id)->first();
            $user->name=$request->name;
            // $user->company=$request->company;
            $user->phone=$request->phone;
            $user->city=$request->city;
            $user->state=$request->state;
            $user->address=$request->address;
        if($user->save()){
            return response()->json(['Success'=>'user Updated Successfully!','user'=>$user??[]],200);
        }else{
            return response()->json(['fail'=>'User not Updated'],500);
        }
    }

    public function userDelete($id)
    {
        $user = User::where('id', $id)->whereHas('role',function ($query) {
            $query->where('name','user');
        })->first();
        if(!empty($user)){
            if($user->delete()) return response()->json(['status'=>'successfully deleted'],200);
        }else{
            return response()->json(["status" => 'fail', 500]);
        }
    }

    public function sellerDelete($id)
    {
        $user = User::where('id', $id)->whereHas('role',function ($query) {
            $query->where('name','seller');
        })->first();
        if(!empty($user)){
            if($user->delete()) return response()->json(['status'=>'successfully deleted'],200);
        }else{
            return response()->json(["status" => 'fail', 500]);
        }
    }
}
