<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;
use App\Http\Requests\StaticPagesRequest;
use Illuminate\Support\Facades\Storage;

class StaticPagesController extends Controller
{

    public function index($id)
    {
        $staticPage = StaticPage::find($id);
        if ($id == 1 || $id == 2) {
            return view('ControlPanel.static_pages.static')->with('staticPage', $staticPage);
        }
        return view('ControlPanel.static_pages.onboarding')->with('staticPage', $staticPage);
    }



    public function staticStore(Request $request, $id)
    {

        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'المحتوى مطلوب',
            'content.string' => 'يجب ان يكون المحتوى نص',
        ]);

        if ($id == 3 || $id == 4 || $id == 5) {
            $request->validate([
                'title' => 'required|string',
                'image' => 'nullable|image',
            ], [
                'title.required' => 'العنوان مطلوب',
                'title.string' => 'يجب ان يكون العنوان نص',
                'image.image' => 'الرجاء اختيار صورة',
            ]);

            $onboarding = StaticPage::find($id);

            if($request->hasFile('image')){
                $image_name = parent::upload_image($request->file('image'));
                $onboarding->image = $image_name;
            }
            

            $onboarding->content = $request['content'];
            $onboarding->title = $request['title'];
            $onboarding->save();
        } else {
            $static = StaticPage::find($id);
            $static->content = $request['content'];
            $static->save();
        }
        return redirect()->back();
    }
}
