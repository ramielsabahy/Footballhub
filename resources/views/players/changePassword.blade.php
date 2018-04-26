@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			Change Password
		</div>
		<div class="panel-body">
			{!!Form::open(['action' => 'PlayersController@updatePassword', 'method' => 'POST'])!!}
				<div class="form-group">
					{{Form::label('userOldPassword', 'Old Password')}}
					{{Form::password('userOldPassword', ['class' => 'form-control', 'placeholder' => 'Old Password'])}}
				</div>
				<div class="form-group">
					{{Form::label('userNewPassword', 'New Password')}}
					{{Form::password('userNewPassword', ['class' => 'form-control', 'placeholder' => 'New Password'])}}
				</div>
				<div class="form-group">
					{{Form::label('userNewPasswordConfirmation', 'Confirm New Password')}}
					{{Form::password('userNewPasswordConfirmation', ['class' => 'form-control', 'placeholder' => 'Confirm New Password'])}}
				</div>
				{{Form::submit('Change', ['class' => 'btn btn-success btn-lg'])}}
				{{Form::hidden('_method', 'PUT')}}
			{!!Form::close()!!}
		</div>
		<div class="panel-footer">
			<a href="/dashboard">
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Cancel
			</a>
		</div>
	</div>
@endsection