<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity; 
use App\Models\Complaint;
use App\Models\Campaign;
use App\Models\Donor;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class CharityUserController extends Controller
{
    public $successStatus = 200;
    
    //login
    public function login(Request $request)
    {
        // $token = Str::random(80);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('charity')->attempt(['email' => request('email'), 'password' => request('password')])){
            // $request->user('charity-api')->forceFill([
            //     'api_token' => hash('sha256', $token),
            // ])->save();
            $admin = Charity::select('_charities.*')->find(auth()->guard('charity')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['charity'])->accessToken; 

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
            'image' => 'image',
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

    public function forgotPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
         $email = $request['email'];
        if(Charity::where('email',$email)->doesntExist()){
            return response()->json(['message' => 'User doesn\'t exists!'],404);
        }

        $token = Str::random(10);
        try{
           DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token
        ]); 
        $details = [
            'title' => 'لقد قمت بطلب إستعادة كلمة مرورك',
            'body' => $token 
        ];
        Mail::to($email)->send(new ForgotPasswordMail($details));
        return response()->json(['message' => 'Check Your Email!!'],200);
        }catch (\Exception $e){
            return response()->json(['message' => $e],404);
        }
        
                
    }

    public function resetPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $token = $request['token'];
        if(!$passwordReset = DB::table('password_resets')->where('token',$token)->first()){
            return response()->json(['message' => 'Invalid Token'],400);
        }
        if(!$user = Charity::where('email',$passwordReset->email)->first()){
            return response()->json(['message' => 'User doesn\'t exists!'],404);
        }

        $user->password = Hash::make($request['password']);
        $user->save();
        return response()->json(['message' => 'success'],200);

    }


    public function logout () {
        try{
            $token = auth()->guard('charity-api')->user()->token();
            $token->revoke();
            $response = ['message' => 'You have been successfully logged out!'];
            return response($response, 200);
        }catch (Exception $e){
            $response = ['message' => $e];
            return response($response, 422);
        }
       
    }


    public function addComplaint(Request $request) 
    { 
            $validator = Validator::make($request->all(), [ 
            'defendant_id' => 'required', 
            'complaint_reason' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = Donor::where('id',$request['defendant_id'])->first();
    
        if($user){
    
            $data = $request->all();
            $data['complainer_id'] = auth()->guard('charity-api')->user()->id;
            $data['complainer_type'] = 'Charity';
            $response = Complaint::create($data);

            if($response){
                return response()->json(['status'=>'success','data'=>$response], $this-> successStatus); 
            }else{
                return response()->json(['status'=>'fail'], 500); 
            }
        }else{
            return response()->json(['message' => 'defendant User Not Found'],400);
        }
    }

    public function addCampaign(Request $request) 
    { 
            $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'expiry_date' => 'required',
            'expiry_time' => 'required',
            'donation_type_id' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

    
        $data = $request->all();
        $data['charity_id'] = auth()->guard('charity-api')->user()->id;
        $response = Campaign::create($data);

        if($response){
              return response()->json(['status'=>'success','data'=>$response], $this-> successStatus); 
        }else{
            return response()->json(['status'=>'fail'], 500); 
        }
        
    }

    public function updateProfile(Request $request){

        $charity = Charity::where('id',auth()->guard('charity-api')->user()->id)->first();

        $charity->name = $request['name'];
        $charity->email = $request['email'];
        $charity->phone = $request['phone'];
        $charity->address = $request['address'];
        $charity->image = $request['image'];
        $charity->activation_status = $request['activation_status'];
        $charity->about = $request['about'];
        $charity->open_time = $request['open_time'];

        $success = $charity->save();

        return response()->json(['success'=>$success,'message'=>'Profile Updated Successfully'], $this-> successStatus); 
    }

    public function updateCampaign (Request $request){
        $validator = Validator::make($request->all(), [ 
            'campaign_id' => 'required',
            'expiry_date' => 'required',
            'expiry_time' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $campaign = Campaign::find($request->campaign_id);
        $campaign->expiry_date = $request->expiry_date;
        $campaign->expiry_time = $request->expiry_time;
        $success = $campaign->update();
        return response()->json(['success'=>$success,'message'=>'Campaign Updated Successfully'], $this-> successStatus); 
    }

    public function deleteCampaign ($id){
        $success = Campaign::find($id)->delete();
        return response()->json(['success'=>$success,'message'=>'Campaign deleted Successfully'], $this-> successStatus); 
    }

    public function setNewAccountPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = auth()->guard('charity-api')->user();
        if(!Hash::check($request['password'], $user->password)){
            return response()->json(['message' => 'Invalid Password'],400);
        }

        $user->password = Hash::make($request['new_password']);
        $user->save();
        return response()->json(['message' => 'Password successfully updated'],200);

    }
}
