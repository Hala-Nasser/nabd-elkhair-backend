<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity; 
use App\Models\Complaint;
use App\Models\Campaign;
use App\Models\Donor;
use App\Models\PaymentLink;
use App\Models\DonationType;
use App\Models\Donation;
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
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

        if(auth()->guard('charity')->attempt(['email' => request('email'), 'password' => request('password')])){
            // $request->user('charity-api')->forceFill([
            //     'api_token' => hash('sha256', $token),
            // ])->save();
            $admin = Charity::select('_charities.*')->find(auth()->guard('charity')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['charity'])->accessToken; 

            return response()->json($this->sendResponse($status=true,$message="User Logged successfully", $data=$success));
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
            'open_time' => 'required', 
            'about' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'address' => 'required',
            'image' => 'image',
            'activation_status' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

    
        $data = $request->all();
        $data['password'] =  bcrypt($request['password']);
        $charity = Charity::create($data);

        $success = $charity->save();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$charity)); 
    }

    public function forgotPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));
        }
         $email = $request['email'];
        if(Charity::where('email',$email)->doesntExist()){
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
        if(!$user = Charity::where('email',$passwordReset->email)->first()){
            return response()->json($this->sendResponse($status=false,$message="User doesn\'t exists!", $data=""));
        }

        $user->password = Hash::make($request['password']);
        $result = $user->save();

        return response()->json($this->sendResponse($status=$result,$message=(($result?"Password reset successfully":"Failed")), $data=""));
    }


    public function logout () {
        try{
            $token = auth()->guard('charity-api')->user()->token();
            $token->revoke();
            return response()->json($this->sendResponse($status=true,"You have been successfully logged out!", $data=""));
        }catch (Exception $e){
            return response()->json($this->sendResponse($status=false,$message=$e, $data=""));
        }
       
    }


    public function addComplaint(Request $request) 
    { 
            $validator = Validator::make($request->all(), [ 
            'defendant_id' => 'required', 
            'complaint_reason' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
    
            $data = $request->all();
            $data['complainer_id'] = auth()->guard('charity-api')->user()->id;
            $data['complainer_type'] = 'Charity';
            $response = Complaint::create($data);
            $status = $response->save();

            return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$response)); 
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
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

    
        $data = $request->all();
        $data['charity_id'] = auth()->guard('charity-api')->user()->id;
        $response = Campaign::create($data);

        $status = $response->save();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$response)); 
        
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

        $status = $charity->save();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Profile updated successfully":"failed"), $data=$charity));
    }

    public function updateCampaign (Request $request){
        $validator = Validator::make($request->all(), [ 
            'campaign_id' => 'required',
            'expiry_date' => 'required',
            'expiry_time' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
        $campaign = Campaign::find($request->campaign_id);
        $campaign->expiry_date = $request->expiry_date;
        $campaign->expiry_time = $request->expiry_time;

        $status = $campaign->update();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Campaign updated successfully":"failed"), $data=$campaign));

    }

    public function deleteCampaign ($id){
        $success = Campaign::find($id)->delete();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Campaign deleted successfully":"failed"), $data=""));
    }

    public function setNewAccountPassword(Request $request){ 

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

        $user = auth()->guard('charity-api')->user();
        if(!Hash::check($request['password'], $user->password)){
            return response()->json($this->sendResponse($status=false,$message="Invalid Password", $data=""));            
        }

        $user->password = Hash::make($request['new_password']);
        $status = $user->save();
        return response()->json($this->sendResponse($status=$status,$message=(($status)?"Password successfully updated":"failed"), $data=""));

    }

    public function setDonationAcceptance (Request $request){
        $validator = Validator::make($request->all(), [ 
            'donation_id' => 'required',
            'acceptance' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
        $donation = Donation::find($request->donation_id);
        $donation->acceptance = $request->acceptance;
        $success = $donation->update();
        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Donation Acceptace successfully updated":"failed"), $data=""));
    }

    public function setDonationReceived (Request $request){
        $validator = Validator::make($request->all(), [ 
            'donation_id' => 'required',
            'received' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }
        $donation = Donation::find($request->donation_id);
        $donation->received = $request->received;
        $success = $donation->update();
        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Donation Received successfully updated":"failed"), $data=""));
    }

    public function addPaymentLinks(Request $request) { 
            $data = $request->all();
            $data['charity_id'] = auth()->guard('charity-api')->user()->id;
            $response = PaymentLink::create($data);

            $status = $response->save();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"success":"failed"), $data=$response)); 
          
    }

   
    public function getComplaints(){
        $list = Complaint::where('complainer_type','Donor')->get(); 
        return response()->json($this->sendResponse($status=true,$message="", $data=$list)); 
    }

    public function getDonationTypes(){
        $list = DonationType::all();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getPaymentLinks(){
        $list = PaymentLink::all();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getCampaigns(){
        $list = Campaign::all();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getCharity(){
        $list = Charity::where('id',auth()->guard('charity-api')->user()->id)->get();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getDonations(){
        $list = Donation::with('donor')->with('campaign')
        ->get(); 
        // $diffInDays = $user->created_at->diffInDays();
        //  $showDiff =  $user->created_at->addDays($diffInDays)->diffInHours().' Hours';
        // echo $showDiff;
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }
    
}
