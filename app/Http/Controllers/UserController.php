<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use Auth;
use Session;

class UserController extends Controller
{
    //
    public function profile(Request $r){
        $payments = Application::where('email',Auth::user()->email)->get();
        return view('profile.index',compact('payments'));
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function yearGroup(){
        $group = User::where('yeargroup',Auth::user()->yeargroup)->get();
        return view('profile.yeargroup',compact('group'));
    }

    public function saveProfile(Request $r){
        $user = User::find(Auth::user()->id);
        $user->title = $r->title;
        $user->firstname = $r->firstname;
        $user->lastname = $r->lastname;
        $user->yeargroup = $r->yeargroup;
        $user->email = $r->email;
        $user->phone = $r->phone;
        $user->house = $r->house;
        $user->status = $r->status;
        $user->save();
        Session::flash('success','Profile Updated Successfully');
        return back();
    }

   
}
