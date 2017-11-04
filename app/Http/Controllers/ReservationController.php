<?php

namespace dbtiPortal\Http\Controllers;

use Illuminate\Http\Request;

use dbtiPortal\Http\Requests;
use dbtiPortal\Http\Controllers\MailController;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    function saveReservation(Request $request){
        $strandInfos = \dbtiPortal\CtrElective::where('strand',$request->strand)->where('elecode',$request->elective)->orderBy('id','DESC')->first();
        $reservation = new \dbtiPortal\SlotReservation;
        $reservation->idno = \Auth::User()->idno;
        $reservation->strand = $request->strand;
        $reservation->elective = $strandInfos->elective;
        $reservation->elecode = $request->elective;
        $reservation->semester = $strandInfos->semester;
        $reservation->schoolyear = $strandInfos->schoolyear;
        $reservation->save();            
//        MailController::sendEmailConfirmation($reservation);
        
        return Redirect::back();
    }

    function saveReservationNew(Request $request){
        $strandInfos = \dbtiPortal\CtrElective::find($request->elective);

        $reservation = new \dbtiPortal\SlotReservation;
        $reservation->idno = \Auth::User()->idno;
        $reservation->strand = $strandInfos->strand;
        $reservation->elective = $strandInfos->elective;
        $reservation->elecode = $strandInfos->elecode;
        $reservation->semester = $strandInfos->semester;
        $reservation->schoolyear = $strandInfos->schoolyear;
        $reservation->save();

        MailController::sendEmailConfirmation($reservation);

        return Redirect::back();
    }
}
