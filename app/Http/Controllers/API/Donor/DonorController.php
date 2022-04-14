<?php

namespace App\Http\Controllers\API\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor; 
use App\Models\Charity; 
use App\Models\Complaint;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth; 
use Validator;

class DonorController extends Controller
{
    public $successStatus = 200;

    //login
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        
        if(auth()->guard('donor')->attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Donor::select('donors.*')->find(auth()->guard('donor')->user()->id);
            $user['token'] =  $user->createToken('MyApp',['donor'])->accessToken; 
            $success = true;
            return response()->json(['success'=>$success, 'data'=> $user], $this-> successStatus);
            
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

        $donor_info = Donor::find($donor->id);

        return response()->json(['success'=>$success, 'data'=> $donor_info], $this-> successStatus); 
    }


    public function storeFCMToken($id, $fcm)
    {
        $donor = Donor::find($donor->id);
        $donor->fcm_token = $token;
        $success = $donor->save();
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    //forgot password
    public function forgotPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
         $email = $request['email'];
        if(Donor::where('email',$email)->doesntExist()){
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

    //reset password
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
        if(!$user = Donor::where('email',$passwordReset->email)->first()){
            return response()->json(['message' => 'User doesn\'t exists!'],404);
        }

        $user->password = Hash::make($request['password']);
        $user->save();
        return response()->json(['message' => 'success'],200);

    }

    //change password
    public function setNewAccountPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = auth()->guard('donor-api')->user();
        if(!Hash::check($request['password'], $user->password)){
            return response()->json(['message' => 'Invalid Password'],400);
        }

        $user->password = Hash::make($request['new_password']);
        $user->save();
        return response()->json(['message' => 'Password successfully updated'],200);

    }

    //logout
    public function logout () {
        try{
            $token = auth()->guard('donor-api')->user()->token();
            $token->revoke();
            $response = ['message' => 'You have been successfully logged out!'];
            return response($response, 200);
        }catch (Exception $e){
            $response = ['message' => $e];
            return response($response, 422);
        }
       
    }

    //add complaint     

            public function addComplaint(Request $request) 
            { 
                $validator = Validator::make($request->all(), [ 
                    'defendant_id' => 'required', 
                    'complaint_reason' => 'required',
                ]);

                if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
                }

                $user = Charity::where('id',$request['defendant_id'])->first();
            
                if($user){

                    $data = $request->all();
                    $data['complainer_id'] = auth()->guard('donor-api')->user()->id;
                    $data['complainer_type'] = 'Donor';
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


         public function addDonation(Request $request){
            $validator = Validator::make($request->all(), [ 
                'charity_id' => 'required', 
                'donation_type_id' => 'required',
                'donation_way' => 'required',
                'donor_phone' => 'required',
                'donor_district' => 'required',
                'donor_city' => 'required',
                'donor_address' => 'required',
            ]);

            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }

             $data = $request->all();
                    $data['donor_id'] = auth()->guard('donor-api')->user()->id;
                    $response = Donation::create($data);

                    if($response){
                        return response()->json(['status'=>'success','data'=>$response], $this-> successStatus); 
                    }else{
                        return response()->json(['status'=>'fail'], 500); 
                    }

         }   
}