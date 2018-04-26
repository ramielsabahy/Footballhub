@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			Create Your Team
		</div>
		<div class="panel-body">
			{!!Form::open(['action' => 'TeamsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
				<div class="form-group">
					{{Form::label('name', 'Team Name')}}
					{{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Team Name'])}}
				</div>
				<div class="form-group">
					{{Form::label('description', 'Team Description')}}
					{{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Team Description', 'id' => 'article-ckeditor'])}}
				</div>
				<div class="form-group">
					{{Form::label('logo', 'Logo')}}
					{{Form::file('logo')}}
				</div>
		</div>
		<div class="panel-footer">
				{{Form::submit('Create', ['class' => 'btn btn-success btn-lg'])}}
			{!!Form::close()!!}
			<a href"/dashboard" class="btn btn-danger btn-lg pull-right">Cancel</a>
		</div>
	</div>
@endsection