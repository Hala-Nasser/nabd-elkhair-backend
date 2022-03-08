<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function index(Request $request){
        $charities = Charity::select('*')->Paginate(1);    
        // $categories = Category::select('*')->get();
        return view('ControlPanel.home')->with('charities', $charities);
    }
}
