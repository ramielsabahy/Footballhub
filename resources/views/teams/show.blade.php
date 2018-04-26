@extends('layouts.app')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		{{$team->name}}
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<img src="/storage/team_logo/{{$team->logo}}" class="team-logo">
			</div>
			<div class="col-md-6 col-md-offset-1">
				<h2>Description</h2>
				<hr/>
				{!!$team->description!!}
				@if(count($accepted_invitations))
					<br/>
					<h2>Team Players</h2>
					<hr/>
					<table class="table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<th>Player ID</th>
								<th>Player Name</th>
								@if(!Auth::guest())
									@if(Auth::user()->id == $team->user_id)
										<th>Delete Player</th>
									@endif
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach($accepted_invitations as $accepted_invitation)
								<tr>
									<td>{{$accepted_invitation->user->id}}</td>
									<td>
										<a href="/players/{{$accepted_invitation->user->id}}">
											{{$accepted_invitation->user->name}}
										</a>
									</td>
									@if (!Auth::guest())
										@if (Auth::user()->id == $team->user_id)
											<td>
					                            {!!Form::open(['action' => 'InvitationsController@destroy', 'method' => 'POST', 'class' => 'pull-left'])!!}
					                                {{Form::hidden('team_id', $accepted_invitation->team_id)}}
					                                {{Form::hidden('player_id', $accepted_invitation->user_id)}}
					                                {{Form::hidden('_method', 'PUT')}}
					                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Delete Player">
					                                    <button type="submit" onclick="return confirm('Are you sure to delete this player ?');" style="border: 0; background: none;">
					                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
					                                    </button>
					                                </a>
					                            {!!Form::close()!!}
							                </td>
										@endif
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
			</div>
		</div>
	</div>
	<div class="panel-footer">
		Created {{$team->created_at->diffForHumans()}} by {{$creator->name}}
		@if (!Auth::guest())
			@if (Auth::user()->id == $team->user_id)
                <a href="/teams/{{$team->id}}/edit" class="tooltips pull-right" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                </a>
                {!!Form::open(['action' => ['TeamsController@destroy', $team->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Delete">
                        <button type="submit" onclick="return confirm('Are you sure to delete this team ?');" style="border: 0; background: none;">
                            <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                        </button>
                    </a>
                {!!Form::close()!!}
			@endif
		@endif
	</div>
</div>
@if(!Auth::guest())
@if(Auth::user()->id == $team->user_id)
	@if(count($pending_invitations))
		<div class="panel panel-default">
			<div class="panel-heading">
				Pending Invitations
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<td>Player ID</td>
							<td>Player Name</td>
							<td>Cancel Invitation</td>
						</tr>
					</thead>
					<tbody>
						@foreach($pending_invitations as $pending_invitation)
							<tr>
								<td>{{$pending_invitation->user->id}}</td>
								<td>{{$pending_invitation->user->name}}</td>
								<td>
		                            {!!Form::open(['action' => 'InvitationsController@destroy', 'method' => 'POST', 'class' => 'pull-left'])!!}
		                                {{Form::hidden('team_id', $pending_invitation->team_id)}}
		                                {{Form::hidden('player_id', $pending_invitation->user_id)}}
		                                {{Form::hidden('_method', 'PUT')}}
		                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Cancel Invitation">
		                                    <button type="submit" onclick="return confirm('Are you sure to cancel this invitation ?');" style="border: 0; background: none;">
		                                        <i class="fa fa-close fa-2x" aria-hidden="true"></i>
		                                    </button>
		                                </a>
		                            {!!Form::close()!!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif
	@if(count($withdrawn_invitations))
		<div class="panel panel-default">
			<div class="panel-heading">
				Withdrawn Invitations
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<td>Player ID</td>
							<td>Player Name</td>
							<td>Clear</td>
						</tr>
					</thead>
					<tbody>
						@foreach($withdrawn_invitations as $withdrawn_invitation)
							<tr>
								<td>{{$withdrawn_invitation->user->id}}</td>
								<td>{{$withdrawn_invitation->user->name}}</td>
								<td>
		                            {!!Form::open(['action' => 'InvitationsController@destroy', 'method' => 'POST', 'class' => 'pull-left'])!!}
		                                {{Form::hidden('team_id', $withdrawn_invitation->team_id)}}
		                                {{Form::hidden('player_id', $withdrawn_invitation->user_id)}}
		                                {{Form::hidden('_method', 'PUT')}}
		                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Clear Invitation">
		                                    <button type="submit" style="border: 0; background: none;">
		                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
		                                    </button>
		                                </a>
		                            {!!Form::close()!!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif
	@if(count($rejected_invitations))
		<div class="panel panel-default">
			<div class="panel-heading">
				Rejected Invitations
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<td>Player ID</td>
							<td>Player Name</td>
							<td>Clear</td>
						</tr>
					</thead>
					<tbody>
						@foreach($rejected_invitations as $rejected_invitation)
							<tr>
								<td>{{$rejected_invitation->user->id}}</td>
								<td>{{$rejected_invitation->user->name}}</td>
								<td>
		                            {!!Form::open(['action' => 'InvitationsController@destroy', 'method' => 'POST', 'class' => 'pull-left'])!!}
		                                {{Form::hidden('team_id', $rejected_invitation->team_id)}}
		                                {{Form::hidden('player_id', $rejected_invitation->user_id)}}
		                                {{Form::hidden('_method', 'PUT')}}
		                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Clear Invitation">
		                                    <button type="submit" style="border: 0; background: none;">
		                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
		                                    </button>
		                                </a>
		                            {!!Form::close()!!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif
@endif
@endif
@endsection