@extends('layouts.app')
@section('content')
<div class='container'>
	<div class='col-md-offset-3 col-md-6'>
		<div class='panel panel-default'>
			<div class='panel-heading'><h3>Update Password</h3></div>
			<div class='panel-body'>
				<form class='form-horizontal' method='post' action="{{url('/changepassword')}}" id='updatePass'>
				{{csrf_field()}}
					<div class='form-group'>
                                @if ($errors->has('new_pass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_pass') }}</strong>
                                    </span>
                                @endif
						<label class='col-md-4'>New Password</label>
						<div class='col-md-6'>
							<input class='form-control' type="password" name="new_pass">
						</div>
					</div>
					<div class='form-group'>
                                @if ($errors->has('renew_pass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('renew_pass') }}</strong>
                                    </span>
                                @endif
						<label class='col-md-4'>Re-type New Password</label>
						<div class='col-md-6'>
							<input class='form-control' type="password" name="renew_pass">
						</div>
					</div>
					<input type="submit" onclick="lock()" id="subutton" class="btn btn-danger navbar-left" style="float:right">
				</form>
			</div>
	</div>
	</div>
</div>
<script type="text/javascript">
    function lock(){
		$("#subutton").prop("disabled",true);
		$("#subutton").prop("value","Wait");
		document.getElementById("updatePass").submit();
	}
</script>
@stop