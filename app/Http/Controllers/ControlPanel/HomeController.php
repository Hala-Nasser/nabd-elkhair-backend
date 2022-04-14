<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\Donor;
use App\Models\DonationType;
use App\Models\Complaint;

class HomeController extends Controller
{
    public function index(Request $request){
        $donors_count = Donor::count();
        $charities_count = Charity::count();
        $donation_types_count = DonationType::count();
        $complaints_count = Complaint::count();
        $charities = Charity::select('*')->where('activation_status',0)->get();
        return view('ControlPanel.home')->with('charities_count',$charities_count)->with('donors_count',$donors_count)->with('donation_types_count',$donation_types_count)->with('complaints_count',$complaints_count)->with('charities', $charities);
    }
}
