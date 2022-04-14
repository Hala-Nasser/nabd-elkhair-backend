<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;
use App\Http\Requests\StaticPagesRequest;

class StaticPagesController extends Controller
{
    public function aboutIndex(Request $request){
        $about = StaticPage::select('*')->where("name", "عن التطبيق")->first();
        if(is_null($about)){
            $new_about = new StaticPage();
            $new_about->content = "عن التطبيق";
            $new_about->name = "عن التطبيق";

            $result = $new_about->save();
            return view('ControlPanel.static_pages.about')->with('about', $new_about);
        }
        return view('ControlPanel.static_pages.about')->with('about', $about);
    }

    public function aboutStore(StaticPagesRequest $request){
    
            $about = StaticPage::select('*')->where("name", "عن التطبيق")->first();
            
            $about->content = $request['content'];
            $about->name = $request['name'];
            
            $result = $about->save();
    
            if ($result) {
                return redirect('home');
            }else{
                return redirect()->back();
            }
    
    }

    public function privacyIndex(Request $request){
        $privacy = StaticPage::select('*')->where("name", "سياسة الاستخدام")->first();
        if(is_null($privacy)){
            $new_privacy = new StaticPage();
            $new_privacy->content = "سياسة الاستخدام";
            $new_privacy->name = "سياسة الاستخدام";

            $result = $new_privacy->save();
            return view('ControlPanel.static_pages.privacy')->with('privacy', $new_privacy);
        }
        //dd($privacy);
        return view('ControlPanel.static_pages.privacy')->with('privacy', $privacy);
    }

    public function privacyStore(StaticPagesRequest $request){
    
            $privacy = StaticPage::select('*')->where("name", "سياسة الاستخدام")->first();
            
            $privacy->content = $request['content'];
            $privacy->name = $request['name'];
            
            $result = $privacy->save();
    
            if ($result) {
                return redirect('home');
            }else{
                return redirect()->back();
            }
    
    }

    public function onboarding1Index(Request $request){
        $onboarding1 = StaticPage::select('*')->where("name", "شاشة الترحيب الاولى")->first();
        if(is_null($onboarding1)){
            $new_onboarding1 = new StaticPage();
            $new_onboarding1->content = "شاشة الترحيب الاولى";
            $new_onboarding1->name = "شاشة الترحيب الاولى";

            $result = $new_onboarding1->save();
            return view('ControlPanel.static_pages.onboarding1')->with('onboarding1', $new_onboarding1);
        }
        //dd($privacy);
        return view('ControlPanel.static_pages.onboarding1')->with('onboarding1', $onboarding1);
    }

    public function onboarding1Store(StaticPagesRequest $request){
    
            $onboarding1 = StaticPage::select('*')->where("name", "شاشة الترحيب الاولى")->first();
            
            $onboarding1->content = $request['content'];
            $onboarding1->name = $request['name'];
            
            $result = $onboarding1->save();
    
            if ($result) {
                return redirect('home');
            }else{
                return redirect()->back();
            }
    
    }
}
