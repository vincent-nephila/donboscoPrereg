<?php

namespace dbtiPortal\Http\Controllers;

use dbtiPortal\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myaccess = \Auth::user()->accesslevel;
        switch($myaccess){
            case env('USER_ADMIN');
                $students = DB::select("select *,users.status as stat,users.idno as idnum from users join statuses on statuses.idno=users.idno where level='Grade 11' and statuses.status=2 and schoolyear=2017");
                return view('admin.home',compact('students'));
            break;
        
            case env('USER_STUDENT');
                if( \Auth::user()->status == 1){
                    $enrolled = $this->enrolled(\Auth::user()->idno);

                    if($enrolled){
                        return view('student.choose2ndElective');
                    }else{
                        return view('student.chooseElective');
                    }
                    
                }else{
                    return view('student.currentlyInactive');
                }
            break;
        }
    }

    function enrolled($idno){
        $schoolyear = \dbtiPortal\CtrSchoolYear::first()->schoolyear;
        $enrolled = \dbtiPortal\Status::where('idno',$idno)->where('schoolyear',$schoolyear)->exists();

        if($enrolled){
            return true;
        }else{
            return false;
        }
    }
    
    function testme(){
        Mail::send('email.test',[],function ($m) {
            $m->from(env('MAIL_USERNAME'), 'Don Bosco Portal');
            //$m->to('vincent@nephilaweb.com.ph', 'John Vincent')->subject('Temporary Password');
            $m->to('dragonite_555@yahoo.com', 'John Vincent')->subject('Welcome to your new account');
        });
        
        if( count(Mail::failures()) > 0 ) {

           echo "There was one or more failures. They were: <br />";

           foreach(Mail::failures as $email_address) {
               echo " - $email_address <br />";
            }

        } else {
            echo "No errors, all sent successfully!";
        }
    }
    
}
