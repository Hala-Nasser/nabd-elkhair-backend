<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;
use App\Http\Requests\StaticPagesRequest;
use Illuminate\Support\Facades\Storage;

class StaticPagesController extends Controller
{

    public function index($id){
        $staticPage = StaticPage::find($id);
        if($id == 1 || $id == 2){
            return view('ControlPanel.static_pages.static')->with('staticPage', $staticPage);
        }
        return view('ControlPanel.static_pages.onboarding')->with('staticPage', $staticPage);
    }



    public function staticStore(Request $request, $id){

        $request->validate([
            'content'=> 'required|string',
        ],[
            'content.required'=> 'المحتوى مطلوب',
            'content.string'=> 'يجب ان يكون المحتوى نص',
        ]);

        if($id == 3 || $id == 4 || $id == 5){
            $request->validate([
                'title' => 'required|string',
                'image' => 'nullable|image',
            ],[
                'title.required'=> 'العنوان مطلوب',
                'title.string'=> 'يجب ان يكون العنوان نص',
                'image.image'=> 'الرجاء اختيار صورة',
            ]);

            $onboarding = StaticPage::find($id);

        $image = $request->file('image');
        $path = 'public/uploads/images/';
        $image_name = time()+rand(1,10000000) . '.' . $image->getClientOriginalExtension();
        Storage::disk('local')->put($path.$image_name, file_get_contents($image));
        $status = Storage::disk('local')->exists($path.$image_name);
    
        if ($status) { 
            $onboarding->content = $request['content'];
            $onboarding->title = $request['title'];
            $onboarding->image = $image_name;
            $result = $onboarding->save();
        }
        }else{
            $static = StaticPage::find($id);
            $static->content = $request['content'];
            $result = $static->save();
        }
        return redirect('home');   
    }


 }