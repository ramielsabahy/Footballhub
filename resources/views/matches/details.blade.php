@extends('layouts.main')

@section('content')
<div class="row" style="margin-top: 150px">
    <div class="col-lg-12">
        <div class="card-box">

            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div>

            <h4 class="header-title m-t-0 m-b-15">Owner : {{$details->owner->fullName}}</h4>
            <h4 class="header-title m-t-0 m-b-15">Place : {{$details->place}}</h4>
            <h4 class="header-title m-t-0 m-b-15">Time : {{$details->time}}</h4>
            <h4 class="header-title m-t-0 m-b-15">Match Name : {{$details->matchName}}</h4>
            <h4 class="header-title m-t-0 m-b-15">Status : 
                @if($details->status == 1)
                    Didn't Start yet
                @elseif($details->status == 2)
                    Started
                @else
                    Ended
                @endif
            </h4>

            <p class="text-muted font-18 m-b-15" style="text-align: center;">
                Friendly Invitations.
            </p>

            <table class="table table-striped m-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Player Name</th>
                        <th>Player Email</th>
                        <th>Player Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($details->friendlyInvitations))
                        <?php $i=1; ?>
                        @foreach($details->friendlyInvitations as $player)
                        <?php
                            $user = \App\User::findOrFail($player->player_id);
                        ?>
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{ $user->fullName }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobileNumber }}</td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    @else
                    <tr>
                        <td>
                            No Invitations
                        </td>
                    </tr>
                    @endif    
                </tbody>
            </table>

        </div>
    </div><!-- end col -->

</div>


@endsection