<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticPage;

class StaticPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->removeAbout();
        $this->storeAbout();
        $this->removePrivacy();
        $this->storePrivacy();
        $this->removeOnBoarding1();
        $this->storeOnBoarding1();
        $this->removeOnBoarding2();
        $this->storeOnBoarding2();
        $this->removeOnBoarding3();
        $this->storeOnBoarding3();
    }

    public function storeAbout(){
        $new_about = new StaticPage();
        $new_about->id = 1;
        $new_about->content = "عن التطبيق";
        $new_about->name = "عن التطبيق";

            $result = $new_about->save();
    }

    public function removeAbout(){
        $about = StaticPage::find(1);
        if(!(is_null($about))){
            $result = $about->delete();
        }
        
    }

    public function storePrivacy(){
            $new_privacy = new StaticPage();
            $new_privacy->id = 2;
            $new_privacy->content = "سياسة الاستخدام";
            $new_privacy->name = "سياسة الاستخدام";

            $result = $new_privacy->save();
    }

    public function removePrivacy(){
        $privacy = StaticPage::find(2);
        if(!(is_null($privacy))){
            $result = $privacy->delete();
        }
        
    }

    public function storeOnBoarding1(){
        $new_onboarding1 = new StaticPage();
        $new_onboarding1->id = 3;
        $new_onboarding1->content = "شاشة الترحيب الاولى";
        $new_onboarding1->name = "شاشة الترحيب الاولى";

        $result = $new_onboarding1->save();
}

public function removeOnBoarding1(){
    $onboarding1 = StaticPage::find(3);
    if(!(is_null($onboarding1))){
        $result = $onboarding1->delete();
    }
    
}

public function storeOnBoarding2(){
    $new_onboarding2 = new StaticPage();
    $new_onboarding2->id = 4;
    $new_onboarding2->content = "شاشة الترحيب الثانية";
    $new_onboarding2->name = "شاشة الترحيب الثانية";

    $result = $new_onboarding2->save();
}

public function removeOnBoarding2(){
$onboarding2 = StaticPage::find(4);
if(!(is_null($onboarding2))){
    $result = $onboarding2->delete();
}

}

public function storeOnBoarding3(){
    $new_onboarding3 = new StaticPage();
    $new_onboarding3->id = 5;
    $new_onboarding3->content = "شاشة الترحيب الثالثة";
    $new_onboarding3->name = "شاشة الترحيب الثالثة";

    $result = $new_onboarding3->save();
}

public function removeOnBoarding3(){
$onboarding3 = StaticPage::find(5);
if(!(is_null($onboarding3))){
    $result = $onboarding3->delete();
}

}
}
