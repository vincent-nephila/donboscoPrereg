<?php

namespace dbtiPortal\Http\Controllers\Auth;

use Illuminate\Http\Request;

use dbtiPortal\Http\Requests;
use dbtiPortal\Http\Controllers\Controller;
use Redirect;
use Validator;
use Hash;

class UpdatePassword extends Controller
{
    /*
    Update password page
    */
    public function changePassword(){
        return view('student.resetPassword');
    }

    /*
    Veriffy, process and save the new pasword
    */
    public function newPassword(Request $request){

        $this->validate($request, [
            'new_pass' => 'required|min:6',
            'renew_pass' => 'required|same:new_pass',
        ]);

        $user = \dbtiPortal\User::where('idno',\Auth::user()->idno)->first();
        $user->password = bcrypt($request->new_pass);
        $user->save();

        return redirect('/')->with('message', 'Password has been changed!');
    }    
}
