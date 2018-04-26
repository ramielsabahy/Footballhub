@extends('layouts.app')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		{{$player->name}} Profile
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="container"><h3>User Details</h3></div>
			<hr/>
			<div class="container">
				<div class="col-md-6">
					<h4>Full Name: {{$player->fullName}}</h4>
					<h4>Mobile Number: {{$player->mobileNumber}}</h4>
				</div>
			</div>
			<hr/>
			<div class="col-md-6">
				@if(count($player->teams))
					<h3>Created Teams</h3>
					<hr/>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					  @foreach($player->teams as $team)
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="heading{{$team->id}}">
					      <h4 class="panel-title">
					        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$team->id}}" aria-expanded="false" aria-controls="collapse{{$team->id}}">
					          {{$team->name}}
					        </a>
					      </h4>
					    </div>
					    <div id="collapse{{$team->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$team->id}}">
					      <div class="panel-body">
					      	{!!$team->description!!}
					      </div>
					      <div class="panel-footer">
					      	<a href="/teams/{{$team->id}}">Know More...</a>
					      </div>
					    </div>
					  </div>
					  @endforeach
					</div>
				@else
					<h3>Created Teams</h3>
					<hr/>
					<h4>No Teams To Show</h4>
				@endif
			</div>
			<div class="col-md-6">
				@if(count($player_joined_teams))
					<h3>Joined Teams</h3><hr/>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					@foreach($player_joined_teams as $player_joined_team)
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="heading{{$player_joined_team->team_id}}">
					      <h4 class="panel-title">
					        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$player_joined_team->team_id}}" aria-expanded="false" aria-controls="collapse{{$player_joined_team->team_id}}">
					          {{$player_joined_team->team->name}}
					        </a>
					      </h4>
					    </div>
					    <div id="collapse{{$player_joined_team->team_id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$player_joined_team->team_id}}">
					      <div class="panel-body">
					      	{!!$player_joined_team->team->description!!}
					      </div>
					      <div class="panel-footer">
					      	<a href="/teams/{{$player_joined_team->team_id}}">Know More...</a>
					      </div>
					    </div>
					  </div>
					@endforeach
					</div>
				@else
					<h3>Joined Teams</h3>
					<hr/>
					<h4>{{$player->name}} is not a member of any team</h4>
				@endif
			</div>
		</div>
		<div class="row">
			@if (!Auth::guest() && Auth::user()->teams && Auth::user()->id != $player->id && count($not_invited_teams))
				{!!Form::open(['action' => 'InvitationsController@store', 'method' => 'POST', 'class' => 'pull-right form-inline'])!!}
					<div class="form-group">
						{{Form::select('team', $not_invited_teams, $not_invited_teams[0], ['class' => 'form-control'])}}
					</div>
					{{Form::hidden('player_id', $player->id)}}
					{{Form::submit('Invite', ['class' => 'btn btn-primary btn-md'])}}
				{!!Form::close()!!}
			@endif
		</div>
	</div>
	<div class="panel-footer">
		Joined {{$player->created_at->diffForHumans()}}
		@if (!Auth::guest() && Auth::user()->teams && Auth::user()->id != $player->id && !count($not_invited_teams))
			, you have invited this player to all of your teams
		@endif
	</div>
</div>
{{-- <div class="panel panel-default">
	<div class="panel-heading">
		Created Teams
	</div>
	<div class="panel-body">
		@if(count($player->teams))
			@foreach($player->teams as $team)
				<div class="panel panel-default">
					<div class="panel-heading">
						{{$team->name}}
					</div>
					<div class="panel-body">
						{!!$team->description!!}
					</div>
					<div class="panel-footer">
						<a href="/teams/{{$team->id}}">Know more...</a>
					</div>
				</div>
			@endforeach
		@else
			No Teams To Show
		@endif
	</div>
	<div class="panel-footer">
		@if (Auth::user()->id == $player->id)
			<a href="/teams/create">Create</a> A Team Now.
		@endif
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		Joined Teams
	</div>
	<div class="panel-body">
		@if(count($player_joined_teams))
			@foreach($player_joined_teams as $player_joined_team)
				<div class="panel panel-default">
					<div class="panel-heading">
						{{$player_joined_team->team->name}}
					</div>
					<div class="panel-body">
						{!!$player_joined_team->team->description!!}
					</div>
					<div class="panel-footer">
						<a href="/teams/{{$player_joined_team->team->id}}">Know more...</a>
					</div>
				</div>
			@endforeach
		@else
			No Teams To Show
		@endif
	</div>
	<div class="panel-footer">
		<a href="/dashboard">Join</a> A Team Now.
	</div>
</div> --}}
@endsection