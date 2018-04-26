@extends('layouts.main')
@section('content')

<div class="wrapper">
    <div class="container">
	    <div class="row">
	        <div class="col-sm-12">
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
	                <h4 class="header-title m-t-0 m-b-30">Competition Seasons</h4>
	                <div class="row">
						<div class="col-lg-12">
	                        <ul class="nav nav-tabs nav-justified">
					        @foreach($competition->competitionSeasons as $count => $season)
					            <li role="presentation" @if($count == 0) class="active" @endif>
					                <a href="#tab-{{ $season->Id }}" aria-controls="#tab-{{ $season->Id }}" role="tab" data-toggle="tab">{{ $season->Season }}</a>
					            </li>
					        @endforeach 
    						</ul>
						    <!-- Tab panes -->
						    <div class="tab-content">
						        @foreach($competition->competitionSeasons as $count => $season)
						            <div role="tabpanel" @if($count == 0) class="tab-pane active" @else class="tab-pane" @endif id="tab-{{ $season->Id }}">
                                    <div class="panel-group" id="accordion" role="tablist"
                                         aria-multiselectable="true">
								        @foreach ($season->CompetitionSeasonGroups as $count2 => $group)

                                        <div class="panel panel-default bx-shadow-none">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       data-parent="#accordion" href="#{{ $group->Id }}"
                                                       aria-expanded="true" aria-controls="collapseOne">
                                                        {{ $group->Name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="{{ $group->Id }}" class="panel-collapse collapse in"
                                                 role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    {{ $group->Id }}
													
                                                </div>
                                            </div>
                                        </div>

						        		@endforeach
                                    </div>

						            </div>
						        @endforeach 





	                        	
	                            
	                        </div>
	                    </div><!-- end col -->
	                </div>
	                <!-- end row -->
	            </div>
	        </div><!-- end col -->
	    </div>
        <!-- end row -->
</div>
@endsection
