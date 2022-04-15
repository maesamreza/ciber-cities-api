<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class passportAuthController extends Controller
{
    public function registerUserExample(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|Unique:users,email',
            'password'=>'required|min:8',
        ]);
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        auth('user')->attempt([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        //  return auth('user')->user();
        // $access_token_example = auth('user')->user()->createToken('uhugfy')->access_token;
        //return the access token we generated in the above step
        return response()->json(['Success'=>'New User Registered Successfully!'],200);
    }

    /**
     * login user to our application
     */
    public function loginUserExample(Request $request){
        $this->validate($request,[
            'email'=>'required|email|Exists:users,email',
            'password'=>'required|min:8',
        ]);
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            //generate the token for the user
            $user = auth('user')->user();
            $user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;
            //now return this token on success login attempt
            return response()->json(['token' => $user_login_token,'user'=>$user], 200);
        }
        else{
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'UnAuthorised Access'], 500);
        }
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails(){
        //returns details
        auth('user')->user();
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
