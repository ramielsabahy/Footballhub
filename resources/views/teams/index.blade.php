@extends('layouts.app')

@section('content')
@if(count($teams))
	<table class="table table-striped table-responsive table-hover">
		<thead>
			<tr>
				<th>Logo</th>
				<th>Team</th>
				<th>Description</th>
				<th>Team Leader</th>
			</tr>
		</thead>
		<tbody>
		@foreach($teams as $team)
			<tr>
				<td><img src="/storage/team_logo/{{$team->logo}}"/></td>
				<td><a href="/teams/{{$team->id}}">{{$team->name}}</a></td>
				<td>{!!$team->description!!}</td>
				<td><a href="/players/{{$team->user_id}}" clsss="team-logo">{{$team->user->name}}</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	<div class="well">
		No Teams To Show
	</div>
@endif
@endsection