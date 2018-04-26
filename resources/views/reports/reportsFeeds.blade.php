@extends('layouts.main')

@section('content')
<style type="text/css">
    .paginate_button
    {
        margin: 10px;
    }
</style>

<h2 style="margin-top: 150px">Report #{{ $report->id }} Feed-Reports</h2>
<hr/>

@if(isset($message))
    <div id="msg" style="width:100%; background-color: green; color:white; text-align: center">{{$message}}</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="reportReportsTable" class="table table-striped table-bordered footable">
                <thead>
                    <tr>
                        <th class="col-md-1">Report Type</th>
                        <th class="col-md-1">Report Description</th>
                 <!--        <th class="col-md-1">Reporting User</th>
                        <th class="col-md-1">Reported Feed Content</th>
                  -->       <!-- <th class="col-md-1">Reported Feed Thumbnail</th>
                        <th class="col-md-1">Feed Report Created At</th>
                        <th class="col-md-1">Delete The General Feed</th> -->  
                        <th></th>       
                    </tr>
                </thead>
                <tbody id="reportReportsBody">

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/footable.min.js')}}"></script>

<script>
    $(function(){
        $('#msg').delay(2000).fadeOut(1000); 
    });

    function getUsers() {
        $('#reportReportsTable').dataTable({
        "processing": false,
        "responsive": true,
        "bDestroy": true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search",
            "sLengthMenu": "Display _MENU_ Records",
            "paginate": {
                "previous": "Previous",
                "next": "Next",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available"
            }
        },
        "ajax": {
                "url": "{{URL::route('viewReportFeeds')}}",
                "data": "{report_id: {{ $report->id }}, user_id: {{Auth::user()->id}}}",
                "dataSrc": "",
        },
        columns: [
             { data: 'type' },
             { data: 'description' },
             
        ],
        columnDefs: [
           {
               "targets": 2,
               "render": function (data, type, row) {
                    return '<a href="/admins/editView/'+row['id']+'" title="Edit"><img src="{{URL::asset('assets/images/edit.png')}}" width="30px" /></a> | ' +
                   '<a href="#" onclick="RemoveUser(' + row['id'] + '); return false; " title="Delete"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a>';

               }
           }

        ]

    });
    }

    $(function () {
        $('#usersTable').on('draw.dt', function () {
            $('.footable').footable({
                breakpoints: {
                    phone: 480,
                    tablet: 800
                }
            });
        });
        getUsers();
    });

    function RemoveUser(id) {
        var chk = confirm('Sure to delete?');
        if (chk == true) {
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $.ajax({
                    url: "{{URL::route('userDestroy')}}",
                    dataSrc: "",
                    data: {'id': id, 'user_id': "{{Auth::user()->id}}"},
                    type:'POST',
                    success: OnRequestCompleted
                    , error: function(xhr, textStatus, errorThrown){
                        console.log(textStatus);
                        console.log(errorThrown);
                        console.log(xhr);
                    }
            });
        }
    }
    function OnRequestCompleted(response) {
        if (response.Status) {
            setPopup(response.Message, 'green', 1500);
        }
        else {
            setPopup(response.Message, '#DD0B0B', 1500);
        }
        $('#err_Desc').fadeOut(300);
        $('#sumbitBtn').attr('disbaled', false);
        getUsers();
    }
    </script>

    <script>
    $(function(){
        $('#msg').delay(2000).fadeOut(1000); 
    });

    function getInvitations() {
        $('#invitations').dataTable({
        "processing": false,
        "responsive": true,
        "bDestroy": true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search",
            "sLengthMenu": "Display _MENU_ Records",
            "paginate": {
                "previous": "Previous",
                "next": "Next",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available"
            }
        },
        "ajax": {
                "url": "{{URL::route('fetchTeamPlayers')}}",
                "dataSrc": "0.invitations",
        },
        columns: [
             { data: 'status' },
             { data: 'user_id' },
             
        ],
        columnDefs: [
           {
               "targets": 2,
               "render": function (data, type, row) {
                    return '<a href="/admins/editView/'+row['id']+'" title="Edit"><img src="{{URL::asset('assets/images/edit.png')}}" width="30px" /></a> | ' +
                   '<a href="#" onclick="RemoveUser(' + row['id'] + '); return false; " title="Delete"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a>';

               }
           }

        ]

    });
    }

    $(function () {
        $('#usersTable').on('draw.dt', function () {
            $('.footable').footable({
                breakpoints: {
                    phone: 480,
                    tablet: 800
                }
            });
        });
        getInvitations();
    });

    function RemoveUser(id) {
        var chk = confirm('Sure to delete?');
        if (chk == true) {
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $.ajax({
                    url: "{{URL::route('userDestroy')}}",
                    dataSrc: "",
                    data: {'id': id, 'user_id': "{{Auth::user()->id}}"},
                    type:'POST',
                    success: OnRequestCompleted
                    , error: function(xhr, textStatus, errorThrown){
                        console.log(textStatus);
                        console.log(errorThrown);
                        console.log(xhr);
                    }
            });
        }
    }
    function OnRequestCompleted(response) {
        if (response.Status) {
            setPopup(response.Message, 'green', 1500);
        }
        else {
            setPopup(response.Message, '#DD0B0B', 1500);
        }
        $('#err_Desc').fadeOut(300);
        $('#sumbitBtn').attr('disbaled', false);
        getInvitations();
    }
    </script>
@endsection