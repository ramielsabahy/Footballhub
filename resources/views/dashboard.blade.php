@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Join Team
    </div>
    <div class="panel-body">
        {!!Form::open(['action' => 'InvitationsController@joinWithCode', 'method' => 'POST', 'class' => 'pull-left form-inline'])!!}
            <div class="form-group">
                {{Form::label('code', 'Code')}}
                {{Form::text('code', '', ['class' => 'form-control', 'placeholder' => 'Team Code'])}}
            </div>
            {{Form::submit('Join', ['class' => 'btn btn-primary btn-md'])}}
        {!!Form::close()!!}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Created Teams</div>

    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (count($created_teams))
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Created</th>
                        <th>Description</th>
                        <th>Join Code</th>
                        <th>Manage Team</th>
                        <th>Regenerate Join Code</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($created_teams as $created_team)
                    <tr>
                        <td><a href="/teams/{{$created_team->id}}">{{$created_team->name}}</a></td>
                        <td>{{$created_team->created_at->diffForHumans()}}</td>
                        <td>{!!$created_team->description!!}</td>
                        <td>{{$created_team->code}}</td>
                        <td>
                            <a href="/teams/{{$created_team->id}}/edit" class="tooltips pull-left" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                            </a>
                            {!!Form::open(['action' => ['TeamsController@destroy', $created_team->id], 'method' => 'POST', 'class' => 'pull-left'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <button type="submit" onclick="return confirm('Are you sure to delete this team ?');" style="border: 0; background: none;">
                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                                    </button>
                                </a>
                            {!!Form::close()!!}
                        </td>
                        <td>
                            {!!Form::open(['action' => 'InvitationsController@regenerate', 'method' => 'PUT'])!!}
                                {{Form::hidden('team_id', $created_team->id)}}
                                {{Form::hidden('_method', 'PUT')}}
                                {{Form::submit('Regenerate', ['class' => 'btn btn-primary btn-md'])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Invite A Player By Id
                </div>
                <div class="panel-body">
                    {!!Form::open(['action' => 'InvitationsController@store', 'method' => 'POST', 'class' => 'pull-left form-inline'])!!}
                        <div class="form-group">
                            <select name="team_id" class="form-control">
                                @foreach($created_teams as $created_team)
                                    <option value="{{$created_team['id']}}">{{$created_team['name']}}</option>
                                @endforeach
                            </select>
                            {{Form::text('player_id', '', ['class' => 'form-control', 'placeholder' => 'Player ID'])}}
                        </div>
                        {{Form::submit('Invite', ['class' => 'btn btn-primary btn-md'])}}
                    {!!Form::close()!!}
                </div>
            </div>
        @else
            You did not created teams yet, <a href="/teams/create">create</a> your own team now. 
        @endif
    </div>
    <div class="panel-footer">
        <a href="/teams/create" class="btn btn-primary btn-md">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Create New Team
        </a>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Recieved Invitations
    </div>
    <div class="panel-body">
        @if(count($received_invitations))
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Team ID</th>
                        <th>Team Name</th>
                        <th>Team Owner</th>
                        <th>Team Description</th>
                        <th>What To Do?</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($received_invitations as $received_invitation)
                    <tr>
                        <td>{{$received_invitation->team_id}}</td>
                        <td>
                            <a href="/teams/{{$received_invitation->team_id}}">
                                {{$received_invitation->team->name}}
                            </a>
                        </td>
                        <td>
                            <a href="/players/{{$received_invitation->user_id}}">
                                {{$received_invitation->user->name}}
                            </a>
                        </td>
                        <td>{!!$received_invitation->team->description!!}</td>
                        <td>
                            {!!Form::open(['action' => 'InvitationsController@accept', 'method' => 'POST', 'class' => 'pull-left'])!!}
                                {{Form::hidden('team_id', $received_invitation->team_id)}}
                                {{Form::hidden('player_id', $received_invitation->user_id)}}
                                {{Form::hidden('_method', 'PUT')}}
                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Accept Invitation">
                                    <button type="submit" style="border: 0; background: none;">
                                        <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                                    </button>
                                </a>
                            {!!Form::close()!!}
                            {!!Form::open(['action' => 'InvitationsController@reject', 'method' => 'POST', 'class' => 'pull-left'])!!}
                                {{Form::hidden('team_id', $received_invitation->team_id)}}
                                {{Form::hidden('player_id', $received_invitation->user_id)}}
                                {{Form::hidden('_method', 'PUT')}}
                                <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Reject Invitation">
                                    <button type="submit" onclick="return confirm('Are you sure to reject this invitation ?');" style="border: 0; background: none;">
                                        <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                                    </button>
                                </a>
                            {!!Form::close()!!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            You do not have new invitations
        @endif
    </div>
</div>
@if(count($accepted_invitations))
    <div class="panel panel-default">
        <div class="panel-heading">
            Your Accepted Invitations
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <td>Team ID</td>
                        <td>Team Name</td>
                        <td>Team Owner</td>
                        <td>Team Description</td>
                        <td>Withdraw</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accepted_invitations as $accepted_invitation)
                        <tr>
                            <td>{{$accepted_invitation->team->id}}</td>
                            <td>
                                <a href="/teams/{{$accepted_invitation->team_id}}">
                                    {{$accepted_invitation->team->name}}
                                </a>
                            </td>
                            <td>
                                <a href="/players/{{$accepted_invitation->user_id}}">
                                    {{$accepted_invitation->user->name}}
                                </a>
                            </td>
                            <td>{!!$accepted_invitation->team->description!!}</td>
                            <td>
                                {!!Form::open(['action' => 'InvitationsController@withdraw', 'method' => 'POST', 'class' => 'pull-left'])!!}
                                    {{Form::hidden('team_id', $accepted_invitation->team_id)}}
                                    {{Form::hidden('player_id', $accepted_invitation->user_id)}}
                                    {{Form::hidden('_method', 'PUT')}}
                                    <a class="tooltips" data-toggle="tooltip" data-placement="top" title="Withdraw Invitation">
                                        <button type="submit" onclick="return confirm('Are you sure to withdraw from this team ?');" style="border: 0; background: none;">
                                            <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                {!!Form::close()!!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer">

        </div>
    </div>
@endif
@endsection
