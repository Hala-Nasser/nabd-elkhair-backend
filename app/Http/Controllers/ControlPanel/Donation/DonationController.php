<?php

namespace App\Http\Controllers\ControlPanel\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Charity;
use App\Models\Campaign;
use App\Models\DonationType;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request, $id){
        $charity = Charity::find($id);
        $charity_name = $charity->name;
        $donations = Donation::select('*')->where('charity_id', $id)->get();
        foreach ($donations as $donation){
            $donor = Donor::find($donation->donor_id);
            $donation->donor_name = $donor->name;
            if($donation->campaign_id == null){
                $donation->campaign_name = "بدون حملة";
            }else{
                $campaign = Campaign::find($donation->campaign_id);
                $donation->campaign_name = $campaign->name;
            }
            $donation_type = DonationType::find($donation->donation_type_id);
            $donation->donation_type_image = $donation_type->image;
        }
        return view('ControlPanel.donation.index')->with('donations', $donations)->with('charity_name', $charity_name);
    }

    public function donor(Request $request, $id){
        $donor = Donor::find($id);
        $donor_name = $donor->name;
        $donations = Donation::select('*')->where('donor_id', $id)->get();
        foreach ($donations as $donation){
            $charity = Charity::find($donation->charity_id);
            $donation->charity_name = $charity->name;
            if($donation->campaign_id == null){
                $donation->campaign_name = "بدون حملة";
            }else{
                $campaign = Campaign::find($donation->campaign_id);
                $donation->campaign_name = $campaign->name;
            }
            $donation_type = DonationType::find($donation->donation_type_id);
            $donation->donation_type_image = $donation_type->image;
        }
        return view('ControlPanel.donation.index')->with('donations', $donations)->with('donor_name', $donor_name);
    }
}
