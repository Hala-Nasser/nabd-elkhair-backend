<?php

namespace App\Http\Controllers\ControlPanel\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\PaymentLink;
use App\Models\Donor;

class CharityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $charities = Charity::select('*')->get();
        return view('ControlPanel.charity.index')->with('charities', $charities);
    }

    public function details(Request $request, $id){
        $charity = Charity::find($id);
        $charity->payment_links = PaymentLink::select('*')->where('charity_id', $id)->first();
        return view('ControlPanel.charity.details')->with('charity', $charity);
    }
    

    public function enable (Request $request, $id) {
    
        $charity = Charity::find($id);
        $charity->activation_status = 1;
        $result = $charity->save();

        //if(is_null($charity->first_activiation))
        
        if(is_null($charity->first_activiation)){
            $charity->first_activiation = 1;
            $charity->save();

            $notification_content = ' تم إضافة جمعية ' . $charity->name;
            //send notification
            $this->sendNotification('تم اضافة جمعية جديدة',$notification_content);
            //dd("enter");
        }

        if ($result) {
            return redirect('charity');
        }else{
            return redirect()->back();
        }
    }


    public function disable (Request $request, $id) {
    
        $charity = Charity::find($id);
        $charity->activation_status = 0;
        $result = $charity->save();

        if ($result) {
            return redirect('charity');
        }else{
            return redirect()->back();
        }
    }

    
        public function destroy ($id) {
    
            $charity = Charity::find($id);
            $result = $charity->delete();
            return redirect('charity');
        }



        //public function sendNotification($token , $title , $body){
        public function sendNotification($title , $body){
           
            $SERVER_API_KEY = 'AAAAicpoaxc:APA91bHeJOgxSWWShrTXKNbJktNGj3l4zKuM7b5rkO40Tsf7n0MGOKHXX-2kXTzvAm2CSUjfloo98v9zH1Y8g5aRlfjRNDDrC1oet79cbn1o3Nwbc8LcGETk29vzCNoRfC6RZo_f7Kic';

            $donors = Donor::select('*')->whereNotNull('fcm_token')->get();
            //dd($donors);

            foreach($donors as $d){
                $token = $d->fcm_token;
                //dd($token);
                $data = [
                    "registration_ids" => [
                        $token
                    ],
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ],
                ];
                $dataString = json_encode($data);
                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                $response = curl_exec($ch);
            }
           /* foreach ($tokens as $t){
                
            }*/
    
        }

}
