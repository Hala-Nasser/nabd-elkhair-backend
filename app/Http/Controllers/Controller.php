<?php


namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function saveModel(Request $request, $model, $is_api)
    {

        if (Arr::get($request->all(), 'id')) {
            $obj = $model::findOrFail(Arr::get($request->all(), 'id'));
        } else {
            $obj = new $model();
        }
        if (Arr::has($request->all(), 'image')) {
            if ($is_api)
                $obj->image = $this->upload_image_api($request->file('image'));
            else
                $obj->image = $this->upload_image($request->file('image'));
        }

        if (Arr::has($request->all(), 'password')) {
            $obj->password =  bcrypt($request->password);
        }


        $obj->forceFill(Arr::except($request->all(), ['image', '_token', 'password', 'c_password']));

        $obj->save();
        return $obj;
    }

    protected function sendResponse($status, $message, $data)
    {
        return [
            "status"    => $status,
            "message"   => $message,
            "data"      => $data
        ];
    }

    public function upload_image($image)
    {
        $path = 'public/uploads/images/';
        $image_name = time() + rand(1, 10000000) . '.' . $image->getClientOriginalExtension();
        Storage::disk('local')->put($path . $image_name, file_get_contents($image));

        return $image_name;
    }

    public function upload_image_api($image)
    {
        $path = 'public/uploads/images/';
        $image_name = time() + rand(1, 10000000) . '.' . $image->getClientOriginalName();
        Storage::disk('local')->put($path . $image_name, file_get_contents($image));

        return $image_name;
    }

    public function sendNotification($title, $body, $model, $image, $reciever_type)
    {

        $SERVER_API_KEY = 'AAAAicpoaxc:APA91bHeJOgxSWWShrTXKNbJktNGj3l4zKuM7b5rkO40Tsf7n0MGOKHXX-2kXTzvAm2CSUjfloo98v9zH1Y8g5aRlfjRNDDrC1oet79cbn1o3Nwbc8LcGETk29vzCNoRfC6RZo_f7Kic';

        $recievers = $model::select('*')->whereNotNull('fcm_token')->get();

        foreach ($recievers as $r) {
            if ($r->notification_status == 1) {
                $token = $r->fcm_token;
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
            $this->storeNotification($r->id, $reciever_type, $title, $body, $image);
        }
    }

    public function storeNotification($reciever_id, $reciever_type, $notification_title, $notification_content, $notification_image)
    {
        $notification = new Notification();
        $notification->reciever_id = $reciever_id;
        $notification->reciever_type = $reciever_type;
        $notification->notification_title = $notification_title;
        $notification->notification_content = $notification_content;
        $notification->notification_image = $notification_image;


        $result = $notification->save();
    }

    // public function storeNoti(Request $request)
    // {
    //     $noti = $this->saveModel($request, Notification::class, true);

    //     return response()->json($this->sendResponse($status = (($noti) ? true : false), $message = (($noti) ? "تم تخزين الاشعار بنجاح" : "فشل التخزين"), $data = (($noti) ? $noti : null)));
    // }



    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }
}
