<?php

namespace App\Http\Controllers;

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


    public function saveModel(Request $request, $model)
    {

        if (Arr::get($request->all(), 'id')) {
            $obj = $model::findOrFail(Arr::get($request->all(), 'id'));
        } else {
            $obj = new $model();
        }
        if (Arr::has($request->all(), 'image')) {
            
            $obj->image = $this->upload_image($request->file('image'));
        }

        $obj->forceFill(Arr::except($request->all(), ['image', '_token']));

        $obj->save();
        return $obj;
    }

    protected function sendResponse ($status, $message, $data) {
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
}
