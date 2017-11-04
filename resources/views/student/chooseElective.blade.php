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
        $strandInfos = dbtiPortal\CtrElective::orderBy('id','DESC')->first();
        $withRecord = dbtiPortal\SlotReservation::where('idno',Auth::User()->idno)->where('semester',$strandInfos->semester)->where('schoolyear',$strandInfos->schoolyear)->exists();
        $record = dbtiPortal\SlotReservation::where('idno',Auth::User()->idno)->where('semester',$strandInfos->semester)->where('schoolyear',$strandInfos->schoolyear)->first();
        
        ?>
        @if(!$withRecord)
        <form method="POST" id="electiveform" action="{{url('/saveReservation')}}">
            {{csrf_field()}}

            <div class='form-horizontal'>
                <label class='col-md-3'>Strand</label>
                <div class="col-md-9">
                    <select class='form-control' name="strand" id="strand" onchange="viewoption()">
                        <option value='' hidden="hidden" selected="selected"></option>
                        <option value='ABM'>ABM</option>
                        <option value='STEM'>STEM</option>
                    </select>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div id="choice">
                
            </div>
            <input type="submit" onclick="lock()" id="subutton" class="btn btn-danger" style="float:right">
        </form>
        @else
        <div class="alert alert-info">You have registered to <b>{{$record->strand}}</b> at elective <b>{{$record->elective}}</b> for the first semester.</div>
        @endif
        
    </div>
</div>
<script>
    function viewoption(){
        $.ajax({
            type:"GET",
            url:"/getoption/"+$("#strand").val(),
            success:function(data){
                $("#choice").html(data);
            }
        });
    }

    function lock(){
	$("#subutton").prop("disabled",true);
	$("#subutton").prop("value","Wait");
	document.getElementById("electiveform").submit();
	}
</script>
@endsection
