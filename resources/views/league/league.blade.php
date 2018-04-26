@extends('layouts.main')
<!DOCTYPE html>
<html>
<head>
	<title>League&Tournament</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
	  
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-animate.js" type="text/javascript"></script>
	<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/374704/sortable.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" /> 
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/drag.css') }}">
</head>

<body>

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
			<form action="{{ route('createLeague') }}" method="GET">
				<div class="col-md-9 text-center" id="main-content">
					<div class="tab-content col-md-6" id="dd">
						<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
							<p>
								<i class="fa fa-pencil fa-lg"></i>
								<span class="lead">Group A</span>
							</p>
							<div class="container-fluid" id="dropZone">
								<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="first sortable-formbuilder-ul">
									<li>
										<div id="big" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab-content col-md-6" id="dd">
						<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
							<p>
								<i class="fa fa-pencil fa-lg"></i>
								<span class="lead">Group B</span>
							</p>
							<div class="container-fluid" id="dropZone">
								<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
									<li>
										<div id="big2" ondragenter="return dragEnter(event)" ondrop="return dragDrop1(event)" ondragover="return dragOver(event)"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
						<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
							<p>
								<i class="fa fa-pencil fa-lg"></i>
								<span class="lead">Group C</span>
							</p>
							<div class="container-fluid" id="dropZone">
								<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
									<li>
										<div id="big3" ondragenter="return dragEnter(event)" ondrop="return dragDrop2(event)" ondragover="return dragOver(event)"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
						<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
							<p>
								<i class="fa fa-pencil fa-lg"></i>
								<span class="lead">Group D</span>
							</p>
							<div class="container-fluid" id="dropZone">
								<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
									<li>
										<div id="big4" ondragenter="return dragEnter(event)" ondrop="return dragDrop3(event)" ondragover="return dragOver(event)"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<button type="submit" name="submit" id="button" value="submit" style="align-self: center;"></button>
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
			<div class="col-md-9 text-center" id="main-content">
				<div class="tab-content col-md-6" id="dd">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group A</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul first">
								<li>
									<div id="big" ondragenter="return dragEnter(event)" ondrop="return dragDrop(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group B</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big2" ondragenter="return dragEnter(event)" ondrop="return dragDrop1(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group C</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big3" ondragenter="return dragEnter(event)" ondrop="return dragDrop2(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group D</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big4" ondragenter="return dragEnter(event)" ondrop="return dragDrop3(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group E</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big5" ondragenter="return dragEnter(event)" ondrop="return dragDrop4(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group F</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big6" ondragenter="return dragEnter(event)" ondrop="return dragDrop5(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group G</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big7" ondragenter="return dragEnter(event)" ondrop="return dragDrop6(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content col-md-6" id="dd" style="margin-top: 30px">
					<div role="tabpanel" class="tab-pane active text-left" id="formBuilderContent">
						<p>
							<i class="fa fa-pencil fa-lg"></i>
							<span class="lead">Group H</span>
						</p>
						<div class="container-fluid" id="dropZone">
							<ul class="row sortable-formbuilder" element-drop  ui-sortable="formbuilderSortableOpts" id="sortable-formbuilder-ul">
								<li>
									<div id="big1" ondragenter="return dragEnter(event)" ondrop="return dragDrop7(event)" ondragover="return dragOver(event)"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
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
		$('.search').on('keyup', function(){
			$value = $(this).val();
			$v = [];
			$text = $(".dragElement-wrapper").text();
			$v[0] = $text;
			if($text == ''){
				$text='rmi';
				$.ajax({
				     "type" : "get",
				     "url"   : "{{URL::route('searchLeague')}}",
				     "data" : {'search': $value,"names": $text},
				     success:function(data){
				     	$('.selected').html(data);
				     },
				});
			}else{
				
				$text=$text;

				$.ajax({
				     "type" : "get",
				     "url"   : "{{URL::route('searchLeague')}}",
				     "data" : {'search': $value,"names": $text},
				     success:function(data){
				     	$('.selected').html(data);
				     },
				});
				$text = $text.split(" ");
				console.log($text);
			}
			
		})
		// $('#search').autocomplete({
		// 	source : "{!!URL::route('searchLeague')!!}",
		// 	minLength:1,
		// 	data: {names: "Dream Team"},
		// 	autoFocus:true,
		// 	select:function(e,ui){
		// 		alert(ui);
		// 		console.log(ui);
		// 	}
		// });
	</script>
	<script type="text/javascript">
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
		function dragDrop(ev) {
		var big1 = document.getElementById("big").getElementsByTagName("li").length;
		if(big1 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop1(ev) {
		var big2 = document.getElementById("big2").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop2(ev) {
		var big2 = document.getElementById("big3").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop3(ev) {
		var big2 = document.getElementById("big4").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop4(ev) {
		var big2 = document.getElementById("big5").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop5(ev) {
		var big2 = document.getElementById("big6").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop6(ev) {
		var big2 = document.getElementById("big7").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
		function dragDrop7(ev) {
		var big2 = document.getElementById("big8").getElementsByTagName("li").length;
		if(big2 < 4 ){
		   var data = ev.dataTransfer.getData("Text");
		   ev.target.appendChild(document.getElementById(data));
		   ev.stopPropagation();
		   return false;
		}
		else{
			alert("Can't exceed the maximum number of four teams in one group.");
		}
		}
	</script>
	<script type="text/javascript">
		$(function() {
		  $('#groupselector').change(function(){
		    	if($('#groupselector option:selected').val() == 4){
			    $('.container-fluid').show();
			    $('.selectors').hide();
			}else{
			    $('.container-fluid-8').show();
			    $('.selectors').hide();
			}
		  });
		});
		
	</script>
</body>

</html>