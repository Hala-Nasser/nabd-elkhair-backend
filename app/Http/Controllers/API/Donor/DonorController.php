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
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
        
        if(auth()->guard('donor')->attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Donor::select('donors.*')->find(auth()->guard('donor')->user()->id);
            $user['token'] =  $user->createToken('MyApp',['donor'])->accessToken; 
            return response()->json($this->sendResponse($status=true,$message="User Logged successfully", $data=$user));
            
        }else{ 
            return response()->json($this->sendResponse($status=false,$message="Email or Password are Wrong.", $data=""));
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
                    return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
                }

                $data = $request->all();
                $data['password'] =  bcrypt($request['password']);
                $donor = Donor::create($data);

                $success = $donor->save();

                return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$donor)); 
                    
            }




    public function storeFCMToken(Request $request)
    {
        $donor = Donor::find($request['user_id']);
        $donor->fcm_token = $request['fcm'];
        $success = $donor->save();
        return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data="")); 
    }

    //forgot password
    public function forgotPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
         $email = $request['email'];
        if(Donor::where('email',$email)->doesntExist()){
            return response()->json($this->sendResponse($status=false,$message="User doesn\'t exists!", $data=""));
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
        return response()->json($this->sendResponse($status=true,$message="Check Your Email!!", $data=""));
        }catch (\Exception $e){
            return response()->json($this->sendResponse($status=false,$message=$e, $data=""));
        }
        
                
    }

    //reset password
    public function resetPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));
        }

        $token = $request['token'];
        if(!$passwordReset = DB::table('password_resets')->where('token',$token)->first()){
            return response()->json($this->sendResponse($status=false,$message="Invalid Token", $data=""));
        }
        if(!$user = Donor::where('email',$passwordReset->email)->first()){
            return response()->json($this->sendResponse($status=false,$message="User doesn\'t exists!", $data=""));
        }

        $user->password = Hash::make($request['password']);
        $result = $user->save();
        return response()->json($this->sendResponse($status=$result,$message=(($result?"Password reset successfully":"Failed")), $data=""));

    }

    //change password
    public function setNewAccountPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

        $user = auth()->guard('donor-api')->user();
        if(!Hash::check($request['password'], $user->password)){
            return response()->json($this->sendResponse($status=false,$message="Invalid Password", $data=""));            
        }

        $user->password = Hash::make($request['new_password']);
        $status = $user->save();
        return response()->json($this->sendResponse($status=$status,$message=(($status)?"Password successfully updated":"failed"), $data=""));

    }

    //logout
    public function logout () {
        try{
            $token = auth()->guard('donor-api')->user()->token();
            $token->revoke();
            return response()->json($this->sendResponse($status=true,"You have been successfully logged out!", $data=""));
        }catch (Exception $e){
            return response()->json($this->sendResponse($status=false,$message=$e, $data=""));
        }
       
    }

   
           //add complaint
    public function addComplaint(Request $request) 
    { 
            $validator = Validator::make($request->all(), [ 
            'defendant_id' => 'required', 
            'complainer_type' => 'required',
            'complaint_reason' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

    
        $data = $request->all();
        $data['complainer_id'] = auth()->guard('donor-api')->user()->id;
        $response = Complaint::create($data);
        $status = $response->save();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$response)); 
        
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
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
            }

             $data = $request->all();
                    $data['donor_id'] = auth()->guard('donor-api')->user()->id;
                    $response = Donation::create($data);

                    $status = $response->save();

                    return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$response));             

         }   
}