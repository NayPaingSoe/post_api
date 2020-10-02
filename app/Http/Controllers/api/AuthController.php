<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
     $v=Validator::make(request()->all(),[
         'name'=>'required|min:1',
         'email'=>'required|min:4',
         'password'=>'required|min:6',
         'image'=>'mimes:jpg,png,jpeg']);
         if ($v->fails()) {
             return response()->json([
             'status'=>500,
             'message'=>'fail',
             'data'=>$v->errors()
      ]);
     }
   
        $name=request()->name;
        $email=request()->email;
        $password=request()->password;
        $image=request()->image;

        $image_name=uniqid().$image->getClientOriginalName();
        $image->move('images',$image_name);

        $user=User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>bcrypt($password) 
        ]);  
        $token=$user->createToken('social')->accessToken;
     
        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>$user,
            'token'=>$token
        ]);
    }
    public function login()
    {
        $v=Validator::make(request()->all(),[
            'email'=>'required|min:3',
            'password'=>'required|min:3']
            );
            if ($v->fails()) {
                return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$v->errors()
         ]);
        }

        $email=request()->email;
        $password=request()->password;
        
        $cre=['email'=>$email,'password'=>$password];
        if(Auth::attempt($cre)){
            $user=Auth::user();
            $token=$user->createToken('social')->accessToken;
            return response()->json([
                        'status'=>200,
                        'message'=>'success',
                        'data'=>$user,
                        'token'=>$token
                    ]);
        }
        return response()->json([
                    'status'=>500,
                    'message'=>'failed',
                    'data'=>[
                        'error'=>'email and password dont match'
                    ],
                    
                ]);
    }
    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
