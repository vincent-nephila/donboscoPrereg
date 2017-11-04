<?php

namespace dbtiPortal\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use dbtiPortal\Http\Requests;

class MailController extends Controller
{
    static function sendEmailConfirmation($reservation){
        
        Mail::queue('email.elecConfirmation',['reservation' =>$reservation], function ($m) {
            $m->from(env('MAIL_USERNAME'), 'Don Bosco Portal');
            $m->to(\Auth::User()->email, \Auth::User()->lastname." ,".\Auth::User()->firstname)->subject('We have received your request');
        });
    }
    
    static function sendTempPassword($info,$password){
        Mail::send('auth.emails.temppassword',['info'=>$info,'password'=>$password], function ($m)use($info) {
            $m->from(env('MAIL_USERNAME'), 'Don Bosco Portal');
            //$m->to('vincent@nephilaweb.com.ph', 'John Vincent')->subject('Temporary Password');
            $m->to($info->email, $info->lastname." ,".$info->firstname)->subject('Welcome to your new account');
        });
    }

    function closingMessage(){
     $students = \dbtiPortal\Status::where('level','Grade 10')->where('status',2)->get();
     //ignore_user_abort(true);
     foreach($students as $student){
         $info = \dbtiPortal\SlotReservation::where('idno',$student->idno)->first();
         if(count($info)== 0){
             $email = \dbtiPortal\User::where('idno',$student->idno)->first();
		if($email->status == 1){
            Mail::queue('email.reminder',['email'=>$info], function ($m)use($email) {
                $m->from(env('MAIL_USERNAME'), 'Don Bosco Portal');
                //$m->to('vincent@nephilaweb.com.ph', 'John Vincent')->subject('Temporary Password');
                $m->to($email->email, $email->lastname." ,".$email->firstname)->subject('Reminder');
            });
        echo $email->idno;
        }
         }
     }
    }

    function secondSem(){
     $students = \dbtiPortal\Status::where('level','Grade 10')->where('status',2)->get();
     //ignore_user_abort(true);
     foreach($students as $student){
         $info = \dbtiPortal\SlotReservation::where('idno',$student->idno)->where('semester',2)->first();
         if(count($info)== 0){
             $email = \dbtiPortal\User::where('idno',$student->idno)->first();
        if($email->status == 1){
            Mail::queue('email.reminder',['email'=>$info], function ($m)use($email) {
                $m->from(env('MAIL_USERNAME'), 'Don Bosco Portal');
                //$m->to('vincent@nephilaweb.com.ph', 'John Vincent')->subject('Temporary Password');
                $m->to($email->email, $email->lastname." ,".$email->firstname)->subject('Reminder');
            });
        echo $email->idno;
        }
         }
     }
    }


}
