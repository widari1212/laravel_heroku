@extends('layouts.app')
<style type="text/css">
	#edit-profile-form{
		width:80%;
		margin:10px auto;
	}
	#edit-profile-form label{
		margin-top:30px;
	}
	#edit-profile-form button[name=submit]{
		margin-top:30px;
	}
	#edit-profile-form input{
		width: 100%;

	}
</style>
@section('styles')

<style type="text/css">
    .invalid-feedback{display: block !important}
</style>
@endsection

@section('content')

<form id="edit-profile-form" method="post" action="{{url('profile/save_changes')}}"  enctype="multipart/form-data">
	@csrf

	@if( count($errors) > 0)
		<h4 style="color:red;text-align:center;">Check the errors below and try again!</h4>
	@endif

	<label>Add Profile Image:</label>	
	<input type="file" onchange="enabled()" name="profile_image">
	@if ($errors->has('profile_image'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('profile_image') }}</strong>
        </span>
    @endif  <br>

    <label>Add Cover Image:</label>
	<input type="file" onchange="enabled()" name="cover_image">
	@if ($errors->has('cover_image'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cover_image') }}</strong>
        </span>
    @endif  <br>

    <label>Change your Name:</label>
	<input type="text" onkeyup="enabled()" value="{{(!$errors->has('name'))?$user->name:''}}" name="name">
	@if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif <br>

    <label>Change your Email:</label>
	<input type="email" onkeyup="enabled()" value="{{(!$errors->has('email'))?$user->email:''}}" name="email">
	@if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif  <br>

    <label>Change Date of Birth:</label>
	<input type="date" onkeyup="enabled()" value="{{(!$errors->has('birth_date'))?$user->birth_date:''}}" name="birth_date">
	@if ($errors->has('birth_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('birth_date') }}</strong>
        </span>
    @endif  <br>

	<button id="submit" name="submit" disabled> Save Changes</button>
</form>

@endsection

@section('scripts')

<script type="text/javascript">

	function enabled(){
		$('#submit').prop("disabled", false);
	}
</script>

@endsection