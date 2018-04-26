@extends('team.mainIndex')

@section('heading')
    <h2>Active Teams</h2>
    <hr/>
@endsection

@section('addHeading')
    <a href="{{URL::route('createAdminView')}}">New Team</a>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/footable.min.js')}}"></script>

<script>
    $(function(){
        $('#msg').delay(2000).fadeOut(1000); 
    });
    var APP_URL = {!!json_encode(url('/'))!!}
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
                "url": "{{URL::route('fetchTeams')}}",
                "dataSrc": "",
        },
        columns: [
             { data: 'id' },
             { data: 'name' },
             { data: 'code' }
        ],
        columnDefs: [
           {
               "targets": 4,
               "render": function (data, type, row) {
                    return '<a href="#" onclick="SuspendUser(' + row['id'] + '); return false; " title="Suspend"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a>';

               }
           },
           {
               "targets": 3,
               "render": function (data, type, row) {
                    return "<a href='"+APP_URL+"/cpanel/teams/players?id="+row['id']+"'>View All Players</a>";

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

    function SuspendUser(id) {
        var chk = confirm('Sure to Suspend?');
        if (chk == true) {
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $.ajax({
                    url: "{{ route('deactivateTeamCMS') }}",
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
@endsection