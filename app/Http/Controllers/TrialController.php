<?php

namespace App\Http\Controllers;
use App\Models\Trial;
use Illuminate\Http\Request;

class TrialController extends Controller
{
    public function getIndex(){
      $trials = Trial::all()->where('trial_date', '>=', date('Y-m-d'));
      return view('main')->with("trials",$trials);
     }
     public function postTrial(Request $request){
        $request->validate([
         'first_name' => 'required',
         'last_name' => 'required',
         'trial_date' => 'required|after_or_equal:now',
         'time' => 'required',
         'location' => 'required',
         'room' => 'required',
         'phone' => 'required',
         'signature' => 'required',
         'link' => 'required',
         'dept' => 'required',
         'app' => 'required'
         ]);
         
         $trial = new Trial();

         $trial->first_name = $request->first_name;
         $trial->last_name = $request->last_name;
         $trial->trial_date = $request->trial_date;
         $trial->time = $request->time;
         $trial->location = $request->location;
         $trial->room = $request->room;
         $trial->phone = $request->phone;
         $trial->signature = $request->signature;
         $trial->link = $request->link;
        $trial->app = $request->app;
        $trial->dept = $request->dept;

         $trial->save();
         return redirect()->back()->with('message','Zgłoszenie zostało dodane');
     }
     public function postCalc(Request $request){
      $request->validate([
       'date_from' => 'required',
       'date_to' => 'required|after_or_equal:date_from'
       ]);
       $trialsQty = Trial::where("trial_date",">=",$request->date_from)
       ->where("trial_date","<=",$request->date_to)
       ->count();
       return redirect()->back()->with(['trialsQty'=>$trialsQty,'date_from'=>$request->date_from,'date_to'=>$request->date_to]);
   }
}
