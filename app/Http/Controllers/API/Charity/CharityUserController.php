<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class CharityUserController extends Controller
{
    public $successStatus = 200;
    
    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('charity-api')->attempt(['email' => request('email'), 'password' => request('password')])){
            
            $admin = Charity::select('_charities.*')->find(auth()->guard('charity-api')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['charity-api'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email or Password are Wrong.']], 200);
        }
    }


    //register
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ], 
            'open_time' => 'required', 
            'about' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'address' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'activation_status' => 'required'
        ]);

if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

    
        $charity = new Charity();
        $charity->name = $request['name'];
        $charity->email = $request['email'];
        $charity->password = bcrypt($request['password']);
        $charity->phone = $request['phone'];
        $charity->address = $request['address'];
        $charity->image = $request['image'];
        $charity->activation_status = $request['activation_status'];
        $charity->about = $request['about'];
        $charity->open_time = $request['open_time'];

        $success = $charity->save();

        return response()->json(['success'=>$success], $this-> successStatus); 
    }
}
