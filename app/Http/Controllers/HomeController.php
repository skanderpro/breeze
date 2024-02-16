<?php

namespace App\Http\Controllers;



use App\Models\Notification;
use App\Models\Po;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
      if (Auth::user()->accessLevel == '1') {
        $count = Po::where('poPod',"")
        ->get();
      } else {
        $count = Po::where('poPod',"")
        ->where('companyId', '=', Auth::user()->companyId)
        ->get();
      }

      $countresult = count($count);

      $notification = Notification::orderBy('id', 'desc')->first();

      return view('home', compact('countresult', 'notification'));
    }


}
