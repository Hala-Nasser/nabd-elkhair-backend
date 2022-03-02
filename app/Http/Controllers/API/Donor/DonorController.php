<?php

namespace App\Http\Controllers\API\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class DonorController extends Controller
{
    public $successStatus = 200;

    //login
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
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
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ], 
            'c_password' => 'required|same:password', 
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'location' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'activation_status' => 'required'
        ]);

if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

    
        $donor = new Donor();
        $donor->name = $request['name'];
        $donor->email = $request['email'];
        $donor->password = bcrypt($request['password']);
        $donor->phone = $request['phone'];
        $donor->location = $request['location'];
        $donor->image = $request['image'];
        $donor->activation_status = $request['activation_status'];

        $success = $donor->save();

/*
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        */
        /*$success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;*/
return response()->json(['success'=>$success], $this-> successStatus); 
    }

}