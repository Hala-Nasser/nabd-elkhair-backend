<?php

namespace App\Http\Controllers\ControlPanel\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\Complaint;
use App\Models\Donor;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $complaints = Complaint::select('*')->get();
        foreach ($complaints as $complaint) {
            if ($complaint->complainer_type == "charity"){
                $charity = Charity::find($complaint->complainer_id);
                $complaint->complainer_name = $charity->name;
                $donor = Donor::find($complaint->defendant_id);
                $complaint->defendant_name = $donor->name;
            }else{
                $donor = Donor::find($complaint->complainer_id);
                $complaint->complainer_name = $donor->name??null;
                $charity = Charity::find($complaint->defendant_id);
                $complaint->defendant_name = $charity->name;
            }
          }
        return view('ControlPanel.complaint.index')->with('complaints', $complaints);
    }
}
