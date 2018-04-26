@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			Edit Account Information
		</div>
		<div class="panel-body">
			{!!Form::open(['action' => 'PlayersController@update', 'method' => 'POST'])!!}
				<div class="form-group">
					{{Form::label('fullName', 'FULL NAME')}}
					{{Form::text('fullName', $player->fullName, ['class' => 'form-control', 'placeholder' => 'FULL NAME'])}}
				</div>
				<div class="form-group">
					{{Form::label('name', 'NAME')}}
					{{Form::text('name', $player->name, ['class' => 'form-control', 'placeholder' => 'NAME'])}}
				</div>
				<div class="form-group">
					{{Form::label('email', 'EMAIL')}}
					{{Form::text('email', $player->email, ['class' => 'form-control', 'placeholder' => 'EMAIL'])}}
				</div>
				<div class="form-group">
					{{Form::label('password', 'PASSWORD')}}
					{{Form::password('password', '', ['class' => 'form-control', 'placeholder' => 'PASSWORD'])}}
				</div>
				<div class="form-group">
					{{Form::label('mobileNumber', 'MOBILE NUMBER')}}
					{{Form::text('mobileNumber', $player->mobileNumber, ['class' => 'form-control', 'placeholder' => 'MOBILE NUMBER'])}}
				</div>
				{{Form::hidden('_method', 'PUT')}}
				{{Form::submit('Edit', ['class' => 'btn btn-success btn-lg'])}}
			{!!Form::close()!!}
		</div>
		<div class="panel-footer">
			{!!Form::open(['action' => 'PlayersController@destroy', 'method' => 'POST'])!!}
				{{Form::hidden('_method', 'DELETE')}}
				<button type="submit" onclick="return confirm('Are you sure to delete your account ?');" style="border: 0; background: none;"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button> Delete Your Account
			{!!Form::close()!!}
		</div>
	</div>
@endsection