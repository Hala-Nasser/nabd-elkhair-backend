<?php

namespace App\Http\Controllers\ControlPanel\Charity;

use App\Http\Controllers\Controller;
use App\Mail\EnableCharity;
use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\PaymentLink;
use App\Models\Donor;
use Illuminate\Support\Facades\Mail;

class CharityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $charities = Charity::select('*')->get();
        return view('ControlPanel.charity.index')->with('charities', $charities);
    }

    public function details(Request $request, $id)
    {
        $charity = Charity::find($id);
        $charity->payment_links = PaymentLink::select('*')->where('charity_id', $id)->first();
        return view('ControlPanel.charity.details')->with('charity', $charity);
    }


    public function enable(Request $request, $id)
    {

        $charity = Charity::find($id);
        $charity->activation_status = 1;
        $result = $charity->save();

        if (is_null($charity->first_activiation)) {
            $charity->first_activiation = 1;
            $charity->save();

            $notification_content = ' تم إضافة جمعية ' . $charity->name;
            //send notification
            $this->sendNotification('جمعية جديدة', $notification_content, Donor::class, $charity->image, "donor");
        }

        if ($result) {
            $details = [
                'title' => 'تفعيل حسابك',
            ];
           // Mail::to($charity->email)->send(new EnableCharity($details));
            return redirect('charity');
        } else {
            return redirect()->back();
        }
    }


    public function disable(Request $request, $id)
    {

        $charity = Charity::find($id);
        $charity->activation_status = 0;
        $result = $charity->save();

        if ($result) {
            return redirect('charity');
        } else {
            return redirect()->back();
        }
    }


    public function destroy($id)
    {

        $charity = Charity::find($id);
        $result = $charity->delete();
        return redirect('charity');
    }


   
}
