<?php

namespace App\Http\Controllers\API\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Charity;
use App\Models\Complaint;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPasswordMail;
use App\Models\Campaign;
use App\Models\DonationType;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\StaticPage;

class DonorController extends Controller
{
    // public $successStatus = 200;

    //login
    public function login(Request $request)
    {
        if (Donor::where('email', request('email'))->doesntExist()) {
            return response()->json($this->sendResponse($status = false, $message = "المستخدم غير موجود", $data = null));
        }
        if (auth()->guard('donor')->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Donor::select('donors.*')->find(auth()->guard('donor')->user()->id);
            $user['token'] =  $user->createToken('MyApp', ['donor'])->accessToken;
            return response()->json($this->sendResponse($status = true, $message = "تم تسجيل الدخول بنجاح", $data = $user));
        } else {
            return response()->json($this->sendResponse($status = false, $message = "البريد الالكتروني أو كلمة المرور غير صحيحة", $data = null));
        }
    }


    //register
    public function register(Request $request)
    {
        //المفترض افحص انو الايميل مش موجود برضو بالجمعية
        if (Donor::where('email', request('email'))->doesntExist()) {
            $success = false;
            $obj = parent::saveModel($request, Donor::class, true);
            if ($obj) {
                $success = true;
            } else {
                $success = false;
            }
            return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم التسجيل بنجاح" : "فشل التسجيل"), $data = (($success) ? $obj : null)));
        }
        return response()->json($this->sendResponse($status = false, $message = "البريد الالكتروني مستخدم بالفعل", $data = null));
    }

    //store fcm token
    public function storeFCMToken(Request $request)
    {
        $donors = Donor::select('*')->where('fcm_token', $request['fcm'])->get();
        foreach ($donors as $donor) {
            $donor->fcm_token = null;
            $donor->save();
        }
        //المفترض افحص برضو بجدول الجمعيات لكن لسا ما تم اضافة التوكن على بيانات الجدول

        $donor = Donor::find($request['user_id']);
        $donor->fcm_token = $request['fcm'];
        $success = $donor->save();
        return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم اضافة التوكن بنجاح" : "فشل اضافة التوكن"), $data = (($success) ? $donor : null)));
    }

    //forgot password
    public function forgotPassword(Request $request)
    {

        $email = $request['email'];
        if (Donor::where('email', $email)->doesntExist()) {
            return response()->json($this->sendResponse($status = false, $message = "المستخدم غير موجود", $data = null));
        }

        $token = Str::random(10);
        try {
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
        } catch (\Exception $e) {
            return response()->json($this->sendResponse($status = false, $message = $e, $data = ""));
        }
    }

    //reset password
    public function resetPassword(Request $request)
    {
        $token = $request['token'];
        if (!$passwordReset = DB::table('password_resets')->where('token', $token)->first()) {
            return response()->json($this->sendResponse($status = false, $message = "كود التحقق غير صحيح", $data = null));
        }
        if (!$user = Donor::where('email', $passwordReset->email)->first()) {
            return response()->json($this->sendResponse($status = false, $message = "المستخدم غير موجود", $data = null));
        }

        $user->password = Hash::make($request['password']);
        $result = $user->save();
        if($result){
            DB::table('password_resets')->where('token', $token)->delete();
        }
        return response()->json($this->sendResponse($status = $result, $message = (($result ? "تم إعادة تعيين كلمة المرور بنجاح" : "فشل إعادة تعيين كلمة المرور")), $data = (($result ? $user : null))));
    }

    //change password
    public function setNewAccountPassword(Request $request)
    {
        $user = auth()->guard('donor-api')->user();
        if (!Hash::check($request['password'], $user->password)) {
            return response()->json($this->sendResponse($status = false, $message = "كلمة المرور غير صحيحة", $data = null));
        }

        $user->password = Hash::make($request['new_password']);
        $status = $user->save();
        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "تم تغيير كلمة المرور بنجاح" : "فشل تغيير كلمة المرور"), $data = (($status) ? $user : null)));
    }

    //logout
    public function logout()
    {
        try {
            $user = auth()->guard('donor-api')->user();
            $token = $user->token();
            $token->revoke();
            $user->fcm_token = null;
            $user->save();
            return response()->json($this->sendResponse($status = true, "تم تسجيل الخروج بنجاح", $data = ""));
        } catch (\Exception $e) {
            return response()->json($this->sendResponse($status = false, $message = $e, $data = ""));
        }
    }


    //add complaint
    public function addComplaint(Request $request)
    {
        $data = $request->all();
        $data['complainer_id'] = auth()->guard('donor-api')->user()->id;
        $response = Complaint::create($data);
        $status = $response->save();

        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "success" : "failed"), $data = $response));
    }


    public function addDonation(Request $request)
    {
        $data = $request->all();
        $data['donor_id'] = auth()->guard('donor-api')->user()->id;
        $response = Donation::create($data);

        $status = $response->save();

        return response()->json($this->sendResponse($status = $status, $message = (($status) ? "success" : "failed"), $data = $response));
    }

    public function CampaignsAccordingToDonationType($donation_type){
        $campaigns = Campaign::select('*')->where('donation_type_id', $donation_type)->get();
        if($donation_type == 0){
            $campaigns = Campaign::select('*')->get();
        }
        foreach($campaigns as $campaign){
            $campaign->charity = Charity::find($campaign->charity_id);
            $campaign->donation_type = DonationType::find($campaign->donation_type_id);
        }
        
        return response()->json($this->sendResponse($status = true, $message = "تم جلب الحملات بنجاح", $data = $campaigns));
    }

    public function CampaignsAccordingToCharity($charity){
        $campaigns = Campaign::select('*')->where('charity_id', $charity)->get();
        return response()->json($this->sendResponse($status = true, $message = "تم جلب الحملات بنجاح", $data = $campaigns));
    }

    public function charities(){
        $charities = Charity::select('*')->where('activation_status', 1)->get();
        return response()->json($this->sendResponse($status = true, $message = "تم جلب الجمعيات بنجاح", $data = $charities));
    }

    public function charitySearch($keyword){
        $charities = Charity::where('name', 'LIKE', '%' . $keyword . '%')->get();
        return response()->json($this->sendResponse($status = true, $message = "تم جلب الجمعيات المشابهة بنجاح", $data = $charities));

    }

    public function profile($id){
        $donor = Donor::find($id);

        $capmaign_donations_count = count(Donation::select('*')->where('donor_id', $id)->where('received', 1)->whereNotNull('campaign_id')->get());
        $charity_donations_count = count(Donation::select('*')->where('donor_id', $id)->where('received', 1)->whereNull('campaign_id')->get());
        $donor -> capmaign_donations_count = $capmaign_donations_count;
        $donor -> charity_donations_count = $charity_donations_count;

        return response()->json($this->sendResponse($status = true, $message = "تم جلب البيانات بنجاح", $data = $donor));
    }

    public function myDonation($id){
        $donations = Donation::select('*')->where('donor_id', $id)->where('received', 1)->get();

        foreach($donations as $donation){
            if(is_null($donation -> campaign_id)){
                $donation->charity_details = Charity::find($donation->charity_id);
            }else{
                $donation->campaign_details = Campaign::find($donation->campaign_id);
            }
        }

        return response()->json($this->sendResponse($status = true, $message = "تم جلب البيانات بنجاح", $data = $donations));
    }

    public function updateProfile(Request $request){
        $donor = Donor::find($request['id']);

        $obj = parent::saveModel($request, Donor::class, true);

        return response()->json($this->sendResponse($status = $obj, $message = (($obj) ? "تم تعديل الملف الشخصي بنجاح" : "فشل تعديل الملف الشخصي"), $data = $obj));

    }

    public function getDonationTypes(){
        $donation_types = DonationType::select('*')->get();
        return response()->json($this->sendResponse($status = true, $message = "تم جلب البيانات بنجاح", $data = $donation_types));

    }


    public function getStaticPages($id)
    {
        $staticPage = StaticPage::find($id);
        return response()->json($this->sendResponse($status = true, $message = "تم جلب البيانات بنجاح", $data = $staticPage));
    }

}
