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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
            $obj = parent::saveModel($request, Donor::class);
            if ($obj) {
                $success = true;
            } else {
                $success = false;
            }
            return response()->json($this->sendResponse($status = $success, $message = (($success) ? "تم التسجيل بنجاح" : "فشل التسجيل"), $data = (($success) ? $obj : null)));
        }
        return response()->json($this->sendResponse($status = false, $message = "المستخدم موجود بالفعل", $data = null));
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
            $token = auth()->guard('donor-api')->user()->token();
            $token->revoke();
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
}
