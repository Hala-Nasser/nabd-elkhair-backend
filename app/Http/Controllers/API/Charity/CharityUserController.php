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
use App\Models\Notification;
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
    // public $successStatus = 200;
    
    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        }

        if (Charity::where('email', request('email'))->doesntExist()) {
            return response()->json($this->sendResponse($status = false, $message = "المستخدم غير موجود", $data = null));
        }
        if (auth()->guard('charity')->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Charity::select('_charities.*')->find(auth()->guard('charity')->user()->id);
            $user['token'] =  $user->createToken('MyApp', ['charity'])->accessToken;
            if($user->activation_status == 1){
                return response()->json($this->sendResponse($status = true, $message = "تم تسجيل الدخول بنجاح", $data = $user));
            }
            return response()->json($this->sendResponse($status = false, $message = "تعذر تسجيل الدخول بسبب تعطيل حسابك", $data = $user));
        } else {
            return response()->json($this->sendResponse($status = false, $message = "البريد الالكتروني أو كلمة المرور غير صحيحة", $data = null));
        }

    }


    //register
    public function register(Request $request) 
    { 
        // $validator = Validator::make($request->all(), [ 
        //     'name' => 'required', 
        //     'email' => 'required|email', 
        //     'password' => [
        //         'required',
        //         'string',
        //         'min:8',             // must be at least 8 characters in length
        //         'regex:/[a-z]/',      // must contain at least one lowercase letter
        //         'regex:/[A-Z]/',      // must contain at least one uppercase letter
        //         'regex:/[0-9]/',      // must contain at least one digit
        //         'regex:/[@$!%*#?&]/', // must contain a special character
        //     ], 
        //     'c_password' => 'required|same:password',
        //     'open_time' => 'required', 
        //     'about' => 'required',
        //     'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        //     'address' => 'required',
        //     'image' => 'image',
        //     'activation_status' => 'required'
        // ]);

        // if ($validator->fails()) { 
        //     return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        // }

        if (Charity::where('email', request('email'))->doesntExist()) {
            $success = false;
            $obj = parent::saveModel($request, Charity::class, true);
            
            if ($obj) {
                $success = true;
            } else {
                $success = false;
            }
            return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم التسجيل بنجاح" : "فشل التسجيل"), $data = (($success) ? $obj : null)));
        }
        return response()->json($this->sendResponse($status = false, $message = "البريد الالكتروني مستخدم بالفعل", $data = null));
    }


    public function storeFCMToken(Request $request)
    {
        $charities = Charity::select('*')->where('fcm_token', $request['fcm'])->get();
        foreach ($charities as $charity) {
            $charity->fcm_token = null;
            $charity->save();
        }

        $charity = charity::find($request['user_id']);
        $charity->fcm_token = $request['fcm'];
        $success = $charity->save();
        return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم اضافة التوكن بنجاح" : "فشل اضافة التوكن"), $data = (($success) ? $charity : null)));
    }

    public function getCharityDonationTypes($id){
        $list = [];
         $charity = Charity::find($id);
        foreach($charity->donationTypes as $types){
            $type = DonationType::find($types);
            $list[] = $type;
        }

        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
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
            return response()->json($this->sendResponse($status = true, $message = "تم إرسال رمز التحقق إلى بريدك الالكتروني", $data = ""));
        }catch (\Exception $e){
            return response()->json($this->sendResponse($status=false,$message="هناك خلل في الاتصال بالانترنت", $data=""));
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
        if (!$passwordReset = DB::table('password_resets')->where('token', $token)->first()) {
            return response()->json($this->sendResponse($status = false, $message = "كود التحقق غير صحيح", $data = null));
        }
        if (!$user = Charity::where('email', $passwordReset->email)->first()) {
            return response()->json($this->sendResponse($status = false, $message = "المستخدم غير موجود", $data = null));
        }

        $user->password = Hash::make($request['password']);
        $result = $user->save();
        if($result){
                DB::table('password_resets')->where('token', $token)->delete();
        }
        return response()->json($this->sendResponse($status = $result, $message = (($result ? "تم إعادة تعيين كلمة المرور بنجاح" : "فشل إعادة تعيين كلمة المرور")), $data = (($result ? $user : null))));
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
            return response()->json($this->sendResponse($status = false, $message = "كلمة المرور غير صحيحة", $data = null));
        }

        $user->password = Hash::make($request['new_password']);
        $status = $user->save();
        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "تم تغيير كلمة المرور بنجاح" : "فشل تغيير كلمة المرور"), $data = (($status) ? $user : null)));

    }


    public function logout () {
        try {
            $user = auth()->guard('charity-api')->user();
            $token = $user->token();
            $token->revoke();
            $user->fcm_token = null;
            $user->save();
            return response()->json($this->sendResponse($status = true, "تم تسجيل الخروج بنجاح", $data = ""));
        } catch (\Exception $e) {
            return response()->json($this->sendResponse($status = false, $message = $e, $data = ""));
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
        $response = Complaint::create($data);
        $status = $response->save();

        if ($status) {
            $complaints = Complaint::select('*')->where('defendant_id', $request['defendant_id'])->where('complainer_type', $request['complainer_type'])->get();
            if (count($complaints) >= 5) {
                $donor = Donor::find($request['defendant_id']);
                $donor->activation_status = 0;
                $result = $donor->save();
                return response()->json($this->sendResponse($status = true, $message = "إذا أصبح عدد الشكاوي 5 فأكثر، سيتم تعطيل حساب المشتكى عليه", $data = null));
            }
        }

        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "success" : "failed"), $data = ""));
    }

    public function addCampaign(Request $request) 
    { 
        //     $validator = Validator::make($request->all(), [ 
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        //     'expiry_date' => 'required',
        //     'expiry_time' => 'required',
        //     'donation_type_id' => 'required',
        // ]);

        // if ($validator->fails()) { 
        //     return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        // }

        $request['charity_id'] = auth()->guard('charity-api')->user()->id;
        $obj = parent::saveModel($request, Campaign::class, true);

        if($obj){
            $status = true;
            $notification_content = ' تم إضافة حملة ' . $obj->name;
            //send notification
            $this->sendNotification('حملة جديدة', $notification_content, Donor::class, $obj->image, "donor");
        }else{
            $status = false;
        }

        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "تم إضافة الحملة بنجاح" : "فشل إضافة الحملة"), $data = (($obj) ? $obj : null)));        
    }

    public function updateProfile(Request $request){

        //$charity = Charity::where('id',auth()->guard('charity-api')->user()->id)->first();
        $request['id'] = auth()->guard('charity-api')->user()->id;
        $obj = parent::saveModel($request, Charity::class, true);

        return response()->json($this->sendResponse($status = (($obj) ? true : false), $message = (($obj) ? "تم تعديل الملف الشخصي بنجاح" : "فشل تعديل الملف الشخصي"), $data = (($obj) ? $obj : null)));
    }

    public function updateCampaign (Request $request){
        // $validator = Validator::make($request->all(), [ 
        //     'campaign_id' => 'required',
        //     'expiry_date' => 'required',
        //     'expiry_time' => 'required',
        // ]);

        // if ($validator->fails()) { 
        //     return response()->json($this->sendResponse($status=false,$message=$validator->errors(), $data=""));            
        // }
        $campaign = Campaign::find($request->campaign_id);
        $campaign->expiry_date = $request->expiry_date;
        $campaign->expiry_time = $request->expiry_time;

        $status = $campaign->update();

        return response()->json($this->sendResponse($status=$status,$message=(($status)?"Campaign updated successfully":"failed"), $data=$campaign));
    }

    public function deleteCampaign ($id){
        $success = Campaign::find($id)->delete();

        return response()->json($this->sendResponse($status=$success,$message=(($success)?"Campaign deleted successfully":"failed"), $data=""));
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
        $donation->done = 1;
        $success = $donation->update();
        return response()->json($this->sendResponse($status=$success,$message=(($success)? ($donation->acceptance)? "تم قبول التبرع بنجاح":"تم رفض طلب التبرع":"فشل قبول الطلب"), $data=""));
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
        return response()->json($this->sendResponse($status=$success,$message=(($success)? ($donation->received)? "تم تأكيد الإستلام بنجاح":"تم رفض طلب الإستلام":"فشل تأكيد الإستلام"), $data=""));
    }

    public function addPaymentLinks(Request $request) { 
        $obj = parent::saveModel($request, PaymentLink::class, true);
            
        if ($obj) {
            $success = true;
        } else {
            $success = false;
        }
        return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم إضافة بيانات الدفع الخاصة بك" : "فشلت الإضافة"), $data = (($success) ? $obj : null)));
    }

    public function updatePaymentLinks(Request $request) { 
        $obj = parent::saveModel($request, PaymentLink::class, true);

        return response()->json($this->sendResponse($status = (($obj) ? true : false), $message = (($obj) ? "تم تعديل بيانات الدفع الخاصة بك" : "فشل تعديل بيانات الدفع"), $data = (($obj) ? $obj : null)));
    }

   
    public function getComplaints(){
        $list = Complaint::with('donor')->where('defendant_id',auth()->guard('charity-api')->user()->id)
        ->where('complainer_type','Donor')->get(); 
        return response()->json($this->sendResponse($status=true,$message="", $data=$list)); 
    }

    public function getDonationTypes(){
        $list = DonationType::all();    
        return response()->json($this->sendResponse($status=true,$message="تم جلب البيانات", $data=$list));
    }

    public function getPaymentLinks(){
        $list = PaymentLink::where('charity_id',auth()->guard('charity-api')->user()->id)->first();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getCharity(){
        $list = Charity::where('id',auth()->guard('charity-api')->user()->id)->first();    
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getDonationRequests(){
        $list = Donation::with('donor')->with('campaign')
        ->where('done', 0)
        ->where('charity_id',auth()->guard('charity-api')->user()->id)
        ->get(); 
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }


    public function getDonationNotReceived(){
        $list = Donation::with('donor')->with('campaign')->where('acceptance', 1)
        ->where('received', 0)
        ->where('charity_id',auth()->guard('charity-api')->user()->id)
        ->get(); 
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getDonationReceived(){
        $list = Donation::with('donor')->with('campaign')->where('acceptance', 1)
        ->where('received', 1)
        ->where('charity_id',auth()->guard('charity-api')->user()->id)
        ->get(); 
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function CampaignsAccordingToDonationType($donation_type)
    {
        $charity = auth()->guard('charity-api')->user();
        $active_campaings = [];
        $campaigns = Campaign::
         select('*')->where('charity_id',$charity->id)
        ->where('donation_type_id', $donation_type)
        ->with('donation.donor')
        ->get();
        if ($donation_type == 0) {
            $campaigns = Campaign::with('donation')
            ->select('*')
            ->where('charity_id',$charity->id)
            ->with('donation.donor')
            ->get();
        }

        foreach ($campaigns as $campaign) {
            if ($charity->activation_status==1) {
                $donation_type_list = [];
                $donation_type_obj = DonationType::find($campaign->donation_type_id);
                if ($donation_type_obj->name != "مال") {
                    array_push($donation_type_list, DonationType::select('*')->where('name', "مال")->first());
                }
                array_push($donation_type_list, $donation_type_obj);
                $campaign->donation_type = $donation_type_list;
                array_push($active_campaings, $campaign);
            }
        }

        return response()->json($this->sendResponse($status = true, $message = "تم جلب الحملات بنجاح", $data = $active_campaings));
    }

    public function getDonationsCount(){
    
        $id = auth()->guard('charity-api')->user()->id;

        $donationWithCampainCount = count(Donation::with('donor')->with('campaign')->where('charity_id', $id)
        ->where('acceptance', 1)->whereNotNull('campaign_id')->get());

        $donationWithoutCampainCount = count(Donation::with('donor')->where('charity_id', $id)
        ->where('acceptance', 1)->whereNull('campaign_id')->get());

        $count = ["donationWithCampainCount" => $donationWithCampainCount,
        "donationWithoutCampainCount" => $donationWithoutCampainCount
        ];

        return response()->json($this->sendResponse($status=true,$message="", $data=$count));
    }

    public function getCampaignDonations(){
    
        $id = auth()->guard('charity-api')->user()->id;

        $list = Donation::with('donor')->with('campaign')->where('charity_id', $id)
        ->where('acceptance', 1)->whereNotNull('campaign_id')->get();
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }


    public function getWithoutCampaignDonations(){

        $id = auth()->guard('charity-api')->user()->id;

        $list = Donation::with('donor')->where('charity_id', $id)
        ->where('acceptance', 1)->whereNull('campaign_id')->get();
        
        return response()->json($this->sendResponse($status=true,$message="", $data=$list));
    }

    public function getNotifications($reciever_id)
    {
        $notifications = Notification::select('*')->where('reciever_id', $reciever_id)->where('reciever_type','charity')->orderBy('created_at', 'desc')->get();
        return response()->json($this->sendResponse($status = true, $message = "تم جلب البيانات بنجاح", $data = $notifications));
    }

    public function setNotificationStatus(Request $request){
        $charity = Charity::find(auth()->guard('charity-api')->user()->id);
        $charity->notification_status = $request->notification_status;
        $result = $charity->save();
        return response()->json($this->sendResponse($status = $result, $message = (($result)? ($charity->notification_status)? "تم تفيعل الاشعارات بنجاح" : "تم تعطيل الاشعارات" :"فشل تفعيل الاشعارات"), $data = ""));

    }
    
}
