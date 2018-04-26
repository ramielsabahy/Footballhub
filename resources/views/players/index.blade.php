@extends('layouts.app')

@section('content')
@if(count($players))
	<table class="table table-striped table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Weight</th>
				<th>Height</th>
				<th>Date Of Birth</th>
			</tr>
		</thead>
		<tbody>
		@foreach($players as $player)
			<tr>
				<td><a href="/players/{{$player->id}}">{{$player->id}}</a></td>
				<td><a href="/players/{{$player->id}}">{{$player->name}}</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	No Players To Show
@endif
@endsection