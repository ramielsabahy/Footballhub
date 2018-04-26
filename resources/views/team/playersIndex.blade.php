@extends('team.playersMainIndex')

@section('heading')
    <h2>Teams</h2>
    <hr/>
@endsection


@section('scripts')
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/footable.min.js')}}"></script>

<script>
    $(function(){
        $('#msg').delay(2000).fadeOut(1000); 
    });

    function getUsers() {
        $('#usersTable').dataTable({
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
                "url": "{{URL::route('fetchPlayers')}}",
                "dataSrc": "",
                "data": { id: {{ request()->id }} }
        },
        columns: [
             { data: 'member.fullName' },
             { data: 'join_request' },
             { data: 'invitation_request'},
             { data: 'status' }
        ],
        columnDefs: [
           {
               "targets": 4,
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
                    url: "",
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
                "data": { id: {{ request()->id }} }
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
                    url: "",
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