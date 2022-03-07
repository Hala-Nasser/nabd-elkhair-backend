<?php

namespace App\Http\Controllers\ControlPanel\DonationType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonationType;
use App\Http\Requests\AddDonationTypeRequest;
use Illuminate\Support\Facades\Storage;

class DonationTypeController extends Controller
{
    public function index(Request $request){
        $donation_types = DonationType::select('*')->get();
        return view('ControlPanel.donation_type.index')->with('donation_types', $donation_types);
    }

    public function create () {
        return view('ControlPanel.donation_type.create');
    }

    public function store(AddDonationTypeRequest $request){

        $image = $request->file('image');
        $path = 'public/uploads/images/';
    
        $image_name = time()+rand(1,10000000) . '.' . $image->getClientOriginalExtension();
        Storage::disk('local')->put($path.$image_name, file_get_contents($image));
        $status = Storage::disk('local')->exists($path.$image_name);
    
        if ($status) {    
            $donation_type = new DonationType();
            $donation_type->image = $image_name;
    
            $result = $donation_type->save();
    
            if ($result) {
                return redirect('donationtype');
            }else{
                return redirect()->back();
            }
        }
    
    }

    public function destroy ($id) {
        $donation_type = DonationType::find($id);
        $result = $donation_type->delete();
        return redirect()->back();
    }

    public function restore ($id) {
        $result = DonationType::withTrashed()->where('id', $id)->restore();
        return redirect()->back();
    }
}
