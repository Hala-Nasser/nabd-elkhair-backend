<?php

namespace App\Http\Controllers\ControlPanel\DonationType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonationType;
use App\Http\Requests\AddDonationTypeRequest;

class DonationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $donation_types = DonationType::select('*')->get();
        return view('ControlPanel.donation_type.index')->with('donation_types', $donation_types);
    }

    public function create(){
        return view('ControlPanel.donation_type.create');
    }

    public function store(AddDonationTypeRequest $request){
        $obj = parent::saveModel($request, DonationType::class, false);
        if($obj){
            return redirect('donationtype');
        }
        return redirect()->back();
    }


    public function edit($id){
        $donation_type = DonationType::find($id);
        return view('ControlPanel.donation_type.edit')->with('donation_type', $donation_type);
    }

    public function destroy($id){
        $donation_type = DonationType::find($id);
        $result = $donation_type->delete();
        return redirect()->back();
    }

    public function restore($id){
        $result = DonationType::withTrashed()->where('id', $id)->restore();
        return redirect()->back();
    }

}
