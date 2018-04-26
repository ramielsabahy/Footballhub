@extends('layouts.main')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/drag.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
<style type="text/css">
	ul#selected{
		padding-left: 0;
	}
	ul#selected li div {
	    display: inline-block;
	    width: 100%;
	    padding: 8px 10px;
	    border-radius: 7px;
	}
	#sidebar-tab-content{
		height: 600px;
		overflow: scroll;
		overflow-x: hidden;
	}
	#dd1{
		height: 200px;
	}
	#sidebar-tab-content::-webkit-scrollbar { 
	    display: none; 
	}
	#dropZone{
		padding: 0;
	}
	#dropZone #first{
		padding-left: 0;
	}
	div.normal li {
	    display: block;
	    width: 100%;
	    float: left;
	    padding-top: 11px;
	}
	.drag-element.col-md-6{
		width: 100%;
	}
	.dragElement-wrapper .drag-element {
	    display: block;
	    width: 90%;
	    padding: 10px;
	    border: 1px solid #ddd;
	    border-radius: 5px;
	    cursor: pointer;
	}
	.tab-content{
		height: 350px;
	}
	.modal-lg.modal-content{
		height:1500px;
	}
</style>
<script type="text/javascript">
	var dataObject = {};
	var groups = [];
	var singleTeam = {};
	var counter1 = 0;
	var flag  = 0;
	var flag0 = 0;
	var flag1 = 0;
	var eighthFlag = 0;
	var seventhFlag = 0;
	var sixthFlag = 0;
	var fifthFlag = 0;
	var fourthFlag = 0;
	var thirdFlag = 0;
	var secondFlag = 0;
	var c_id = "";
	var s_id = "";
	var teamList = [];
	var teamString = "";
	var cCount = 0;
	var counterForKnockOut = 0;
</script>
@endsection
@section('content')
<!-- Begin the First Round Section -->
<div class="modal fade bs-example-modal-lg" id="first-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Groups Selection</h4>
            </div>
            <div class="modal-body">
              	<header style="margin-top: 100px;">
					<h3 style="text-align: center;">Tournament : First Round</h3>
				</header>
				<div class="selectors">
					<label class="wrapper" for="states">Please select the number of groups</label>
					<div class="button dropdown"> 
					  <select id="groupselector">
					     <option>Please select number of groups</option>	
					     <option value="4">4 Groups</option>
					     <option value="8">8 Groups</option>
					  </select>
					</div>
				</div>
				<div class="container-fluid" style="display: none;">
					<div class="row">
						<div class="col-md-3" id="sideBar" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)">
							
							<div class="tab-content" id="sidebar-tab-content">
								<div role="tabpanel" class="tab-pane active" id="addFieldTab">
									<p>
										<i class="fa fa-lg fa-plus-square-o"></i><i class="fa fa-lg fa-minus-square-o"></i> All Teams
									</p>
									<div class="collapse in" id="stdFields">
										<input type="hidden" name="competition_id" value="" id="competition_id">
										<input type="hidden" name="season_id" value="" id="season_id">
										<ul id="selected" class="selected">
											
										</ul>
									</div>
								</div>
							</div>
						</div>
						<form class="group-teams" class="submitAll" id="submitAll">
							<div class="col-md-9 text-center" id="main-content">
								<?php
								$groups = ['A','B','C','D'];
								?>
								@for($counter = 0 ; $counter < 4 ; $counter++)
									<div class="tab-content col-md-6" id="dd">
										<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
											<p>
												<i class="fa fa-pencil fa-lg"></i>
												<span class="lead">Group {{ $groups[$counter] }}</span>
											</p>
											<div class="container-fluid" id="dropZone">
												<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="first sortable-formbuilder-ul">
												<input type="hidden" name="groups[]" value="Group{{$groups[$counter]}}">
													<li>
														<div style="height: 200px" id="{{$counter}}" class="normal"  ondragenter="return dragEnter(event)" ondrop="return dragDropCounter(event, {{$counter}},{{$counter}})" ondragover="return dragOver(event)"></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								@endfor
								<button class="btn btn-primary" id="team" style="align-self: center;">Submit</button>
							</div>
						</form>
					</div>
				</div>

				<div class="container-fluid container-fluid-8 " style="display: none;margin-top: 100px;">
					<div class="row row8">
						<div class="col-md-3" id="sideBar" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)" style="background-color: white">
							<input type="text" name="search" placeholder="search" id="search" class="search">
							<div class="tab-content" id="sidebar-tab-content">
								<div role="tabpanel" class="tab-pane active" id="addFieldTab">
									<p>
										<a role="button" data-toggle="collapse" href="#stdFields">
											<i class="fa fa-lg fa-plus-square-o"></i><i class="fa fa-lg fa-minus-square-o"></i> All Teams
										</a>
									</p>
									<div class="collapse in" id="stdFields">
										<ul id="selected" class="selected">
											
										</ul>
									</div>
								</div>
							</div>
						</div>
						<form class="submitAll" id="submitAll2">
							<div class="col-md-9 text-center" id="main-content">
								<?php
									$groups = ["A", "B", "C", "D", "E", "F", "G", "H"];
								?>
								@for ($counter = 0; $counter < 8; $counter++)
									<div class="tab-content col-md-6" id="dd">
										<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
											<p>
												<i class="fa fa-pencil fa-lg"></i>
												<span class="lead">Group {{ $groups[$counter] }}</span>
											</p>
											<div class="container-fluid" id="dropZone">
												<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul first">
													<input type="hidden" name="groups[]" value="Group{{$groups[$counter]}}">
													<li>
														<div style="height: 200px" style="height: 200px" style="height: 200px" style="height: 200px" style="height: 200px" id="{{$counter}}" class="normal" ondragenter="return dragEnter(event)" ondrop="return dragDropCounter(event, {{$counter}},{{$counter}})" ondragover="return dragOver(event)"></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								@endfor
								<button class="btn btn-primary" id="team" style="align-self: center;">Submit</button>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Of First Round Section -->
<!-- Begin The Second Round Part -->
<div class="modal fade bs-example-modal-lg" id="second-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Qualifiers Selection</h4>
            </div>
            <div class="modal-body">
              	<header style="margin-top: 100px;">
					<h3 style="text-align: center;">Tournament : Knockout stage</h3>
				</header>
				<div class="qualifiersselectors">
					<label class="wrapper" for="states">How do you want to select teams</label>
					<div class="button dropdown"> 
					  <select id="qualifiersselector">
					     <option value="1">Manually</option>
					     <option value="2">Shuffle</option>
					  </select>
					</div>
				</div>
				<div class="container-fluid" id="qualified" style="display: none;">
					<div class="row">
						<div class="col-md-3" id="sideBar" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)">
							<input type="text" name="search" placeholder="search" id="search" class="search">
							<div class="tab-content" id="sidebar-tab-content">
								<div role="tabpanel" class="tab-pane active" id="addFieldTab">
									<p>
										<a role="button" data-toggle="collapse" href="#stdFields">
											<i class="fa fa-lg fa-plus-square-o"></i><i class="fa fa-lg fa-minus-square-o"></i> All Qualified Teams
										</a>
									</p>
									<div class="collapse in" id="stdFields">
										<input type="hidden" name="competition_id" value="" id="competition_id">
										<input type="hidden" name="season_id" value="" id="season_id">
										<ul id="qualifiedselected" class="qualifiedselected">

										</ul>
									</div>
								</div>
							</div>
						</div>
						<form class="group-teams" class="submitQual" id="submitQual">
							<div class="col-md-9 text-center" id="main-content">
								<?php
									$groups = ["A", "B", "C", "D"];
								?>
								@for ($counter = 0; $counter < 4; $counter++)
									<div class="tab-content col-md-6" id="dd1">
										<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
											<p>
												<i class="fa fa-pencil fa-lg"></i>
												<span class="lead">Slot {{$groups[$counter]}}</span>
											</p>
											<div class="container-fluid" id="dropZone">
												<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="first sortable-formbuilder-ul">
												<input type="hidden" name="groups[]" value="Group{{$groups[$counter]}}">
													<li>
														<div style="height: 200px" id="qual{{$counter}}" class="normal"  ondragenter="return dragEnter(event)" ondrop="return dragDropQual(event,'qual{{$counter}}')" ondragover="return dragOver(event)"></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								@endfor
								<button class="btn btn-primary qualSubmit" id="qualSubmit" style="align-self: center;">Submit</button>
							</div>
						</form>
					</div>
				</div>

				<div class="container-fluid container-fluid-8 " style="display: none;margin-top: 100px;">
					<div class="row row8">
						<div class="col-md-3" id="sideBar" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)" style="background-color: white">
							<input type="text" name="search" placeholder="search" id="search" class="search">
							<div class="tab-content" id="sidebar-tab-content">
								<div role="tabpanel" class="tab-pane active" id="addFieldTab">
									<p>
										<a role="button" data-toggle="collapse" href="#stdFields">
											<i class="fa fa-lg fa-plus-square-o"></i><i class="fa fa-lg fa-minus-square-o"></i> All Qualified Teams
										</a>
									</p>
									<div class="collapse in" id="stdFields">
										<ul id="qualifiedselected2" class="qualifiedselected">
											
										</ul>
									</div>
								</div>
							</div>
						</div>
						<form class="submitQual" id="submitQual2">
							<div class="col-md-9 text-center" id="main-content">
								<?php
									$groups = ["A", "B", "C", "D", "E", "F", "G", "H"];
								?>
								@for ($counter = 0; $counter < 8; $counter++)
									<div class="tab-content col-md-6" id="dd1">
										<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
											<p>
												<i class="fa fa-pencil fa-lg"></i>
												<span class="lead">Slot {{$groups[$counter]}}</span>
											</p>
											<div class="container-fluid" id="dropZone">
												<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="first sortable-formbuilder-ul">
												<input type="hidden" name="groups[]" value="Group{{$groups[$counter]}}">
													<li>
														<div style="height: 200px" id="qual{{$counter}}" class="normal"  ondragenter="return dragEnter(event)" ondrop="return dragDropQual(event,'qual{{$counter}}')" ondragover="return dragOver(event)"></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								@endfor
								<button class="btn btn-primary qualSubmit" id="qualSubmit" style="align-self: center;">Submit</button>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End of second round Part -->

<div class="row" style="margin-top: 150px;">
	<div class="col-lg-12">
	        <div class="card-box">
	            

	            <h4 class="header-title m-t-0 m-b-30">League Information</h4>

	            <form data-parsley-validate id="sForm" data-validate="parsley" enctype="multipart/form-data">
	                <div class="form-group col-lg-6">
	                    <label for="userName">League Name*</label>
	                    <input type="text" name="name" required
	                           placeholder="Enter League Name" class="any form-control" id="league" data-parsley-trigger="change focusout" data-parsley-required=''>
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="emailAddress">Arabic Name</label>
	                    <input type="text" name="arName"
	                           placeholder="Enter Arabic Name" class="form-control" id="arName">
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="logo">Logo</label>
	                    <input id="logo" type="file" name="logo" 
	                           class="form-control">
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="Competition">Competition Type</label>
	                    <select required class="form-control" id="Competition" name="competition" data-parsley-trigger="change focusout" data-parsley-required=''>
                    		<option value="1">Cup</option>
                    		<option value="2">League</option>
                    		<option value="3" selected="true">Tournament</option>
	                    </select>
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="numberOfTeams">Teams Number</label>
	                    <input id="numberOfTeams" type="number" value="16" name="teams" parsley-trigger="change" required
	                           class="form-control" data-parsley-trigger="change focusout" data-parsley-required=''>
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="yellowcards">Yellow Cards to suspend</label>
	                    <input id="yellowcards" type="yellowcards" value="2" name="yellowcards" parsley-trigger="change" required
	                           class="form-control" data-parsley-trigger="change focusout" data-parsley-required=''>
	                </div>
	                <div class="form-group col-lg-6">
	                    <label for="cup">Cup Image</label>
	                    <input id="cup" type="file" name="cup" 
	                           class="form-control">
	                </div>

	                <div class="form-group text-right m-b-0" style="display: inline-block;margin-top: 100px;">
	                    <!-- <button class="btn btn-primary waves-effect waves-light" type="submit">
	                        Submit
	                    </button> -->
	                    <a class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Next</a>
	                </div>
	                <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				    <div class="modal-dialog" id="to-dismiss">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				                <h4 class="modal-title">Competition Information</h4>
				            </div>
				            <div class="modal-body">
				                <div class="row">
				                    <div class="col-md-6">
				                        <div class="form-group">
				                            <label for="season" class="control-label">Season</label>
				                            <input type="month" class="form-control" id="season" name="season" data-parsley-trigger="change focusout" data-parsley-required='true' required>
				                        </div>
				                    </div>
				                </div>
				                <div class="row">
				                	<div class="col-md-6">
				                        <div class="form-group">
				                            <label for="start" class="control-label">Start Date</label>
				                            <input type="datetime-local" class="form-control" id="start" name="start" data-parsley-trigger="change focusout" data-parsley-required='true' required>
				                        </div>
				                    </div>
				                    <div class="col-md-6">
				                        <div class="form-group">
				                            <label for="end" class="control-label">End Date</label>
				                            <input type="datetime-local" class="form-control" id="end" name="end" data-parsley-trigger="change focusout" data-parsley-required='tru' required>
				                        </div>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="col-md-12">
				                        <div class="form-group">
				                            <label for="yellow" class="control-label">Yellow cards to suspend</label>
				                            <input type="number" value="2" class="form-control" id="yellow" name="yellow">
				                        </div>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="col-md-12">
				                        <div class="form-group">
				                            <label for="groups" class="control-label">Number of Groups</label>
				                            <select class="form-control" id="groups" name="groups">
				                            	<option value="4" selected="true">4 Groups</option>
				                            	<option value="8"> 8 Groups</option>
				                            </select>
				                        </div>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="col-md-12">
				                        <div class="form-group no-margin">
				                            <label for="field-7" class="control-label">Personal Info</label>
				                            <select class="form-control" id="capacity" name="capacity">
				                            	<option value="5" selected="true">5 Players</option>
				                            	<option value="7"> 7 Players</option>
				                            	<option value="11"> 11 Players</option>
				                            </select>
				                            {{ csrf_field() }}
				                        </div>
				                    </div>
				                </div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				                <button class="btn btn-info waves-effect waves-light save" id="add-in">Save Cahnges</button>
				            </div>
				        </div>
				    </div>
				</div><!-- /.modal -->
	            </form>
	        </div>
	</div><!-- end col -->
</div>
<div class="row">
<!-- BASIC WIZARD -->
	<div class="col-lg-12">
		<div class="card-box p-b-0">
	        		<h4 class="header-title m-t-0 m-b-30">Seasons</h4>

		        <form class="group-teams" id="group-teams">
		            <div id="basicwizard" class=" pull-in">
		                <ul class="nav nav-tabs navtab-wizard nav-justified bg-muted" id="add-here" style="direction: rtl">
		                    
		                </ul>
		                {{ csrf_field() }}
		                <div class="tab-content b-0 m-b-0">
		                    <div class="tab-pane m-t-10 fade" id="tab1">
		                        <div class="row">
		                            <div class="form-group clearfix">
		                                <label class="col-md-3 control-label " for="userName">Teams *</label>
		                                <div class="col-md-9">
		                                    <select name="teamsList[]" class="multi-select" multiple="" id="my_multi_select3" >
										    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group text-right m-b-0">
		     	                    <button type="submit" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#first-modal" id="gselect">Go to Group selection</button>
		                		</div>
		                    </div>
		                    
		                    
		                </div>

		            </div>
		        </form>
		</div>
	</div>
<!-- end col -->
</div>
@endsection
@section('scripts')
		<!-- Plugins Js -->
        <script src="{{URL::asset('assets/plugins/switchery/switchery.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
     	<script src="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
     	<script src="{{URL::asset('assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
     	<script src="{{URL::asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
     	<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/374704/sortable.js"></script>
        <script type="text/javascript">
		$(function() {
		  $( "#button" ).click(function() {
		    $( "#button" ).addClass( "onclic", 250, validate);
		  });

		  function validate() {
		    setTimeout(function() {
		      $( "#button" ).removeClass( "onclic" );
		      $( "#button" ).addClass( "validate", 450, callback );
		    }, 2250 );
		  }
		    function callback() {
		      setTimeout(function() {
		        $( "#button" ).removeClass( "validate" );
		      }, 1250 );
		    }
		  });
	</script>
	<script type="text/javascript">
		var teams = [];
		
		function dragStart(ev) {	
		   ev.dataTransfer.effectAllowed='move';
		   ev.dataTransfer.setData("Text", ev.target.getAttribute('id'));
		   ev.dataTransfer.setDragImage(ev.target,100,100);
		   return true;
		}
		function dragEnter(ev) {
		   event.preventDefault();
		   return true;
		}
		function dragOver(ev) {
		     event.preventDefault();
		}
		function dragDropCounter(ev,id,count){
			var big = document.getElementById(id).getElementsByTagName("li").length;
			var group = {};
			s_id = dataObject['competition_season_id'];
			c_id = dataObject['competiton_id'];
			if(cCount <= 3){
				group['Name'] = 'A';
			}else if(cCount > 3 && cCount <= 7){
				group['Name'] = 'B';
				if(secondFlag == 0){
					teams = [];
					secondFlag = 1;
				}
			}
			else if(cCount > 7 && cCount <= 11){
				group['Name'] = 'C';
				if(thirdFlag == 0){
					teams = [];
					thirdFlag = 1;
				}
			}else if(cCount > 11 && cCount <= 15){
				group['Name'] = 'D';
				if(fourthFlag == 0){
					teams = [];
					fourthFlag = 1;
				}
			}else if(cCount > 15 && cCount <= 19){
				group['Name'] = 'E';
				if(fifthFlag == 0){
					teams = [];
					fifthFlag = 1;
				}
			}else if(cCount > 19 && cCount <= 23){
				group['Name'] = 'F';
				if(sixthFlag == 0){
					teams = [];
					sixthFlag = 1;
				}
			}else if(cCount > 23 && cCount <= 28){
				group['Name'] = 'G';
				if(seventhFlag == 0){
					teams = [];
					seventhFlag = 1;
				}
			}else if(cCount > 28 && cCount <= 32){
				group['Name'] = 'H';
				if(eighthFlag == 0){
					teams = [];
					eighthFlag = 1;
				}
			}
			cCount++;
			if(big < 4 ){
			   var team = {};
			   var data = ev.dataTransfer.getData("Text");
			   ev.target.appendChild(document.getElementById(data));
			   team['TeamId'] = data;
			   // console.log(data);
			   teams.push(team);
			   counter1++;
			   group['teams'] = teams;
			   // console.log(group);
			   groups[count] = group;
			   dataObject['groups'] = groups;
			   console.log(dataObject);
			   ev.stopPropagation();
			   return false;
			}
			else{
				alert("Can't exceed the maximum number of four teams in one group.");
			}
		}
		function dragDropQual(ev,id){
			var big = document.getElementById(id).getElementsByTagName("li").length;
			var group = {};
			s_id = dataObject['competition_season_id'];
			c_id = dataObject['competiton_id'];
			if(big < 2 ){
			   var team = {};
			   var data = ev.dataTransfer.getData("Text");
			   ev.target.appendChild(document.getElementById(data));
			   teamString += data;
			   if(counterForKnockOut == 1){
			   		teamList.push(teamString);
			   		teamString = "";
			   }
			   else if(counterForKnockOut == 3){
			   		teamList.push(teamString);
			   		teamString = "";
			   }
			   else if(counterForKnockOut == 5){
			   		teamList.push(teamString);
			   		teamString = "";
			   }else if(counterForKnockOut == 7){
			   		teamList.push(teamString);
			   		teamString = "";
			   }
			   counterForKnockOut++;
			   ev.stopPropagation();
			   return false;
			}
			else{
				alert("Can't exceed the maximum number of four teams in one group.");
			}
		}

		function dragDrop(ev) {
			//
		}
	</script>
        <script>
            jQuery(document).ready(function() {
                //advance multiselect start
                $('#my_multi_select3').multiSelect({
                    selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                    selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                    afterInit: function (ms) {
                        var that = this,
                            $selectableSearch = that.$selectableUl.prev(),
                            $selectionSearch = that.$selectionUl.prev(),
                            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                            .on('keydown', function (e) {
                                if (e.which === 40) {
                                    that.$selectableUl.focus();
                                    return false;
                                }
                            });

                        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                            .on('keydown', function (e) {
                                if (e.which == 40) {
                                    that.$selectionUl.focus();
                                    return false;
                                }
                            });
                    },
                    afterSelect: function () {
		                	this.qs1.cache();
                        	this.qs2.cache();
		                	return false;
                        
                    },
                    afterDeselect: function () {
                        this.qs1.cache();
                        this.qs2.cache();
                    }
                });

                // Select2
                $(".select2").select2();

                $(".select2-limiting").select2({
				  maximumSelectionLength: 2	
				});

            });

            //Bootstrap-TouchSpin
            $(".vertical-spin").TouchSpin({
                verticalbuttons: true,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary",
                verticalupclass: 'ti-plus',
                verticaldownclass: 'ti-minus'
            });
            var vspinTrue = $(".vertical-spin").TouchSpin({
                verticalbuttons: true
            });
            if (vspinTrue) {
                $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
            }

            $("input[name='demo1']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary",
                postfix: '%'
            });
            $("input[name='demo2']").TouchSpin({
                min: -1000000000,
                max: 1000000000,
                stepinterval: 50,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary",
                maxboostedstep: 10000000,
                prefix: '$'
            });
            $("input[name='demo3']").TouchSpin({
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });
            $("input[name='demo3_21']").TouchSpin({
                initval: 40,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });
            $("input[name='demo3_22']").TouchSpin({
                initval: 40,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });

            $("input[name='demo5']").TouchSpin({
                prefix: "pre",
                postfix: "post",
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });
            $("input[name='demo0']").TouchSpin({
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });

            // Time Picker
            jQuery('#timepicker').timepicker({
                defaultTIme : false
            });
            jQuery('#timepicker2').timepicker({
                showMeridian : false
            });
            jQuery('#timepicker3').timepicker({
                minuteStep : 15
            });

            //colorpicker start

            $('.colorpicker-default').colorpicker({
                format: 'hex'
            });
            $('.colorpicker-rgba').colorpicker();

            // Date Picker
            jQuery('#datepicker').datepicker();
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            jQuery('#datepicker-inline').datepicker();
            jQuery('#datepicker-multiple-date').datepicker({
                format: "mm/dd/yyyy",
                clearBtn: true,
                multidate: true,
                multidateSeparator: ","
            });
            jQuery('#date-range').datepicker({
                toggleActive: true
            });

            //Date range picker
            $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-default',
                cancelClass: 'btn-primary'
            });
            $('.input-daterange-timepicker').daterangepicker({
                timePicker: true,
                format: 'MM/DD/YYYY h:mm A',
                timePickerIncrement: 30,
                timePicker12Hour: true,
                timePickerSeconds: false,
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-default',
                cancelClass: 'btn-primary'
            });
            $('.input-limit-datepicker').daterangepicker({
                format: 'MM/DD/YYYY',
                minDate: '06/01/2016',
                maxDate: '06/30/2016',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-default',
                cancelClass: 'btn-primary',
                dateLimit: {
                    days: 6
                }
            });

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2016',
                maxDate: '12/31/2016',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-success',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            //Bootstrap-MaxLength
            $('input#defaultconfig').maxlength()

            $('input#thresholdconfig').maxlength({
                threshold: 20
            });

            $('input#moreoptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger"
            });

            $('input#alloptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true
            });

            $('textarea#textarea').maxlength({
                alwaysShow: true
            });

            $('input#placement').maxlength({
                alwaysShow: true,
                placement: 'top-left'
            });
        </script>
<script type="text/javascript">
	$(document).ready(function (){
           $(".js-example-basic-single").select2({
             allowClear:true,
             placeholder: 'Search for Teams'
           });
        });
</script>
<script>

	$("#sForm").submit(function(event){
		event.preventDefault();
		var text = $("#season").val();
	    var year = text.substr(0,4);
		var lis = [];
		if ( $(this).parsley().isValid() ) {
			var LogoUrl = $("#logo").val();
			// var file = $('#logo')[0]['files'][0];
   //           var reader = new FileReader();
   //           reader.readAsDataURL(file);
             var wrapper = {};
             // reader.onload = function () {
             	wrapper = { Name: $("#league").val(), ArName: $("#arName").val(), LogoUrl: '', CompetitionTypeId: $("#Competition").val(), NumberOfTeams: $("#numberOfTeams").val(), YellowCardsToSuspend: $("#yellowcards").val(), cup_logo: $("#cup").val(), Season: year+"/"+(parseInt(year)+1), StartDate: $("#start").val(), EndDate: $("#end").val(), YellowCardsToSuspend: $("#yellow").val(), NumberOfGroups: $("#groups").val(), Status: $("#capacity").val() };
             	console.log(wrapper);
             	$.ajax({
		     "type" : "POST",
		     "url"   : "{{URL::route('CreateCompetitionSeason')}}",
		     "data": wrapper,
		     success:function(data){
		     	var exclude_teams_list = ["WTF"];
		     	dataObject['competition_season_id'] = data['InnerData']['competition_seasons'][0]['Id'];
		     	dataObject['competiton_id'] = data['InnerData']['Id'];
		     	var wrapper = {count: $('#capacity').val(),teams_list: exclude_teams_list};
		     	console.log(wrapper);
		     	$.ajax({
		     		"type" : "POST",
		     		"url"  : "{{URL::route('getTeams')}}",
		     		"data" : wrapper,
		     		success:function(response){
		     			console.log(response);
		     			if(response){
		     				$.each(response, function(index, team) {
								$('#my_multi_select3').append('<option value='+team.id+'>'+team.name+'</option>');
								$('#my_multi_select3').multiSelect('refresh');
								$('#group-teams').submit(function(event){
									if($('#numberOfTeams').val() == 16){
									    $('.container-fluid').show();
									    $('.container-fluid-8').hide();
									    $('.selectors').hide();
									}else{
									    $('.container-fluid-8').show();
									    $('.selectors').hide();
									}
									var x = $('#numberOfTeams').val();
									$('#competition_id').val(x);
									var text = $("#season").val();
								    var year = text.substr(0,4);
								    var fullSeason  = (parseInt(year)+1);
								    $('#season_id').val(year+"/"+fullSeason);
								});
								
							});
		     				$('#gselect').click(function(event){
		     					var c = 0;
								$('.ms-selection ul li:visible').each(function(){
									$('.in .selected').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+response[c]['id']+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td>				    				     <i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+response[c]['name']+'<input type="hidden" name="teams[]" value="'+response[c]['id']+'">												    				     </div>												    				     </li>');
									console.log($('#my_multi_select3').val());
									c++;
								});
		     				});

		     			}else{
		     				alert('no teams with this specification.');
		     			}
		     		}
		     	});
		     	console.log(dataObject['competition_season_id']);
		     	var text = $("#season").val();
		    	var year = text.substr(0,4);
		    	$("#tabs").each(function (){
		    		var listText = $("#add-here li").text().substr(5,8);
		    			lis.push($("#tabs").text());		    		
		    	});
		    	var text = $("#season").val();
		    	var year = text.substr(0,4);
		    	$("#tabs").each(function (){
	    		var listText = $("#add-here li").text().substr(5,8);
	    			lis.push($("#tabs").text());
	    	});
		    	if(data){
			     	$("#add-here").append("<li id=\"tabs\"><a href=\"#tab1\" data-toggle=\"tab\">"+year+"/"+(parseInt(year)+1)+"</a></li>");
			     }else{
			     	alert("sorry, something wen wrong.\nPlease try after while");
			     }
		     },
			});
             // }
             reader.onerror = function (error) {
             	wrapper = { Name: $("#league").val(), ArName: $("#arName").val(), LogoUrl: '', CompetitionTypeId: $("#Competition").val(), NumberOfTeams: $("#numberOfTeams").val(), YellowCardsToSuspend: $("#yellowcards").val(), cup_logo: $("#cup").val(), Season: year+"/"+(parseInt(year)+1), StartDate: $("#start").val(), EndDate: $("#end").val(), YellowCardsToSuspend: $("#yellow").val(), NumberOfGroups: $("#groups").val(), Status: $("#capacity").val() };
             	$.ajax({
		     "type" : "POST",
		     "url"   : "{{URL::route('CreateCompetitionSeason')}}",
		     "data": wrapper,
		     success:function(data){
		     	var exclude_teams_list = ["WTF"];
		     	dataObject['competition_season_id'] = data['InnerData']['competition_seasons'][0]['Id'];
		     	dataObject['competiton_id'] = data['InnerData']['Id'];
		     	var wrapper = {count: $('#capacity').val(),teams_list: exclude_teams_list};
		     	console.log(wrapper);
		     	$.ajax({
		     		"type" : "POST",
		     		"url"  : "{{URL::route('getTeams')}}",
		     		"data" : wrapper,
		     		success:function(response){
		     			console.log(response);
		     			if(response){
		     				$.each(response, function(index, team) {
								$('#my_multi_select3').append('<option value='+team.id+'>'+team.name+'</option>');
								$('#my_multi_select3').multiSelect('refresh');
								$('#group-teams').submit(function(event){
									if($('#numberOfTeams').val() == 16){
									    $('.container-fluid').show();
									    $('.container-fluid-8').hide();
									    $('.selectors').hide();
									}else{
									    $('.container-fluid-8').show();
									    $('.selectors').hide();
									}
									var x = $('#numberOfTeams').val();
									$('#competition_id').val(x);
									var text = $("#season").val();
								    var year = text.substr(0,4);
								    var fullSeason  = (parseInt(year)+1);
								    $('#season_id').val(year+"/"+fullSeason);
								});
								
							});
		     				$('#gselect').click(function(event){
		     					var c = 0;
								$('.ms-selection ul li:visible').each(function(){
									$('.in .selected').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+response[c]['id']+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td>				    				     <i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+response[c]['name']+'<input type="hidden" name="teams[]" value="'+response[c]['id']+'">												    				     </div>												    				     </li>');
									console.log($('#my_multi_select3').val());
									c++;
								});
		     				});

		     			}else{
		     				alert('no teams with this specification.');
		     			}
		     		}
		     	});
		     	console.log(dataObject['competition_season_id']);
		     	var text = $("#season").val();
		    	var year = text.substr(0,4);
		    	$("#tabs").each(function (){
		    		var listText = $("#add-here li").text().substr(5,8);
		    			lis.push($("#tabs").text());
		    	});
		    	var text = $("#season").val();
		    	var year = text.substr(0,4);
		    	$("#tabs").each(function (){
	    		var listText = $("#add-here li").text().substr(5,8);
	    			lis.push($("#tabs").text());	    		
	    	});
		    	if(data){
			     	$("#add-here").append("<li id=\"tabs\"><a href=\"#tab1\" data-toggle=\"tab\">"+year+"/"+(parseInt(year)+1)+"</a></li>");
			     }else{
			     	alert("sorry, something wen wrong.\nPlease try after while");
			     }
		     },
			});
             }		    
		}
	});

	$(".group-teams").submit(function(event){
		event.preventDefault();
		var text = $("#season").val();
	    var year = text.substr(0,4);
		var lis = [];
	    $.ajax({
	     "type" : "POST",
	     "url"   : "{{URL::route('createLeague')}}",
	     "data": "",
	     success:function(data){
	     	console.log(data);
	     	var text = $("#season").val();
	    	var year = text.substr(0,4);
	    	$("#tabs").each(function (){
	    		var listText = $("#add-here li").text().substr(5,8);
	    			lis.push($("#tabs").text());
	    	});
	    	if(data){
		     	alert("yes");
		     }else{
		     	alert("sorry, something wen wrong.\nPlease try after while");
		     }
	     },
		});
	});

	$('#submitAll').submit(function(event){
		event.preventDefault();
		if ((groups[0]['teams']).length < 3 || (groups[1]['teams']).length < 3 || (groups[2]['teams']).length < 3 || (groups[3]['teams']).length < 3) {
			alert("One or more groups have less than 3 teams");
			return false;
		}else{
			$.ajax({
				"type": "POST",
				"url" : "{{URL::route('CreateGroupsGroupsTeams')}}",
				"data": dataObject,
				success:function(data){
					$('#first-modal').fadeOut();
					$('#qualifiersselectors').hide();
					var name = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R"];
					var number = 1;
					for(var counter = 1 ; counter <= $('#numberOfTeams').val()/4 ; counter++){
						for(var innerCount = 1 ; innerCount <= 2 ; innerCount++){
							$('.qualifiedselected').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+innerCount+""+name[counter-1]+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td><i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+innerCount+""+name[counter-1]+'<input type="hidden" name="qualifiedteams[]" value="'+innerCount+""+name[counter-1]+'"></div></li>');
						}
					}
					$('#second-modal').modal('show');
				},
				error:function(data){
					console.log(data);
				}
			});
		}
		
	});
	$('#submitAll2').submit(function(event){
		event.preventDefault();
		if ((groups[0]['teams']).length < 3 || (groups[1]['teams']).length < 3 || (groups[2]['teams']).length < 3 || (groups[3]['teams']).length < 3 || (groups[4]['teams']).length < 3 || (groups[5]['teams']).length < 3 || (groups[6]['teams']).length < 3 || (groups[7]['teams']).length < 3) {
			alert("One or more groups have less than 3 teams");
			return false;
		}else{
			$.ajax({
				"type": "POST",
				"url" : "{{URL::route('CreateGroupsGroupsTeams')}}",
				"data": dataObject,
				success:function(data){
					$('#first-modal').fadeOut();
					$('#qualifiersselectors').hide();
					$('#second-modal').modal('show');
					var name = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R"];
					var number = 1;
					for(var counter = 1 ; counter <= $('#numberOfTeams').val()/4 ; counter++){
						for(var innerCount = 1 ; innerCount <= 2 ; innerCount++){
							$('#qualifiedselected2').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+innerCount+""+name[counter-1]+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td><i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+innerCount+""+name[counter-1]+'<input type="hidden" name="qualifiedteams[]" value="'+innerCount+""+name[counter-1]+'"></div></li>');
						}
					}
					
				},
				error:function(data){
					alert(data);
				}
			});
		}
	});
	$('#submitQual').submit(function(event){
		event.preventDefault();
		var round = 0;
		if(teamList.length == 4){
			round = 3;
		}else{
			round = 2;
		}
		$.ajax({
			"type": "POST",
			"url" : "{{ URL::route('matchMapTeams') }}",
			"data": {competition_season_id: s_id, competiton_id: c_id, matches:teamList, competition_round_id: round},
			success:function(data){
				console.log(data);
				$('#second-modal').fadeOut();
				$('#second-modal').hide();
				$('#qualifiersselectors').hide();
				var name = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R"];
				var number = 1;
				for(var counter = 1 ; counter <= $('#numberOfTeams').val()/8 ; counter++){
					for(var innerCount = 1 ; innerCount <= 2 ; innerCount++){
						$('#semiqualifiedselected').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+innerCount+""+name[counter-1]+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td><i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+innerCount+""+name[counter-1]+'<input type="hidden" name="semiqualifiedteams[]" value="'+innerCount+""+name[counter-1]+'"></div></li>');
					}
				}

			},
			error:function(data){
				console.log(data);
			}
		});
	});
	$('#submitQual2').submit(function(event){
		event.preventDefault();
		var round = 0;
		if(teamList.length == 4){
			round = 3;
		}else{
			round = 2;
		}
		$.ajax({
			"type": "POST",
			"url" : "{{ URL::route('matchMapTeams') }}",
			"data": {competition_season_id: s_id, competiton_id: c_id, teams:teamList, roundNumber: round},
			success:function(data){
				console.log(data);
				$('#second-modal').fadeOut();
				$('#second-modal').hide();
				$('#qualifiersselectors').hide();
				var name = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R"];
				var number = 1;
				for(var counter = 1 ; counter <= $('#numberOfTeams').val()/4 ; counter++){
					for(var innerCount = 1 ; innerCount <= 2 ; innerCount++){
						$('#semiqualifiedselected').append('<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="'+innerCount+""+name[counter-1]+'"><div class="drag-element col-md-6" style="background-color:white;color:black;"></td><i class="fa fa-soccer-ball-o" style="padding-right:15px"> </i>'+innerCount+""+name[counter-1]+'<input type="hidden" name="semiqualifiedteams[]" value="'+innerCount+""+name[counter-1]+'"></div></li>');
					}
				}

			},
			error:function(data){
				console.log(data);
			}
		});
	});
	$('#submitQualSemi').submit(function(event){
		$.ajax({
			"type": "POST",
			"url" : "{{ URL::route('matchMapTeams') }}",
			"data": {competition_season_id: s_id, competiton_id: c_id, teams:teamList},
			success:function(data){
				alert('done');
			},
			error:function(data){
				console.log(data);
			}
		});
	});

$(document).ready(function(){

	var lis = [];
    $("#add-in").click(function(){
    	var text = $("#season").val();
    	var year = text.substr(0,4);
    	$("#tabs").each(function (){
    		var listText = $("#add-here li").text().substr(5,8);
    			lis.push($("#tabs").text());
    	});
        
    });
});
</script>
@endsection