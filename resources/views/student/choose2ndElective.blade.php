@extends('layouts.app')
@section('content')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div style='margin-left: auto;margin-right: auto;width:50%'>
        <table class="table table-striped" >
            <tr>
                <td>Student Id </td>
                <td>{{Auth::user()->idno}}</td>
            </tr>
            <tr>
                <td>Name </td>
                <td>{{Auth::user()->lastname}}, {{Auth::user()->firstname}} {{Auth::user()->middlename}}</td>
            </tr>
            <?php 
            $status = dbtiPortal\Status::where('idno',Auth::user()->idno)->first();
            $checkstat = dbtiPortal\Status::where('idno',Auth::user()->idno)->exists();
            ?>

            <tr>
                <td>Level </td>
                <td>@if($checkstat)
                    {{$status->level}}
                    @else 
                    N/A 
                    @endif</td>
            </tr>
            <tr>
                <td>Section </td>
                <td>@if($checkstat)
                    {{$status->section}}
                    @else 
                    N/A 
                    @endif</td>
            </tr>
        </table>
        <?php 
        $schoolyear = dbtiPortal\CtrSchoolYear::first()->schoolyear;
        $electives = dbtiPortal\CtrElective::where('strand',$status->strand)->where('schoolyear',$schoolyear)->where('semester',2)->get();

        $record = dbtiPortal\SlotReservation::where('idno',Auth::User()->idno)->where('semester',2)->where('schoolyear',$schoolyear)->first();
        
        ?>
        @if(count($record)>0)
            <div class="alert alert-info">
                You have registered to <b>{{$record->strand}}</b> at elective <b>{{$record->elective}}</b> for the first semester.
            </div>
        @else
        <form method="POST" id="electiveform" action="{{url('/save2ndReservation')}}">
            {{csrf_field()}}

            <div id="choice">
            <table border='1' class='table table-bordered' cellspacing='0' width='100%'>

            @foreach($electives as $elective)
            <?php
            $reserved = dbtiPortal\SlotReservation::where('strand',$status->strand)->where('elecode',$elective->elecode)->where('schoolyear',$schoolyear)->count();
            ?>
                <tr>
                    <td><input type='radio' name='elective' value='{{$elective->id}}'></td>
                    <td>{{$elective->elective}}</td>
                    <td>{{$elective->slots - $reserved}}</td></tr>                    
                </tr>
                @endforeach
            </table>
            </div>
            <input type="submit" onclick="lock()" id="subutton" class="btn btn-danger" style="float:right">
        </form>
        @endif
        
    </div>
</div>
<script>

    function lock(){
	$("#subutton").prop("disabled",true);
	$("#subutton").prop("value","Wait");
	document.getElementById("electiveform").submit();
	}
</script>
@endsection
