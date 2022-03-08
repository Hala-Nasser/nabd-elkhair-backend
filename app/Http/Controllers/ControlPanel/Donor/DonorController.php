<?php

namespace App\Http\Controllers\ControlPanel\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $donors = Donor::select('*')->get();
        return view('ControlPanel.donor.index')->with('donors', $donors);
    }

    public function enable (Request $request, $id) {
        $donor = Donor::find($id);
        $donor->activation_status = 1;
        $result = $donor->save();

        if ($result) {
            return redirect('donor');
        }else{
            return redirect()->back();
        }
    }

    public function disable (Request $request, $id) {
    
        $donor = Donor::find($id);
        $donor->activation_status = 0;
        $result = $donor->save();

        if ($result) {
            return redirect('donor');
        }else{
            return redirect()->back();
        }
    }

    
        public function destroy ($id) {
    
            $donor = Donor::find($id);
            $result = $donor->delete();
            return redirect('donor');
        }
}
