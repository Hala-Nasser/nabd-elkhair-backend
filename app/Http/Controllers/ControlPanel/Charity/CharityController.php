<?php

namespace App\Http\Controllers\ControlPanel\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity;

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
        return view('ControlPanel.charity.details')->with('charity', $charity);
    }

    public function enable (Request $request, $id) {
    
        $charity = Charity::find($id);
        $charity->activation_status = 1;
        $result = $charity->save();

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

}
