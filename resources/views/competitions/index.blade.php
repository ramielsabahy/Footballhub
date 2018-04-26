@extends('layouts.main')

@section('content')

<style type="text/css">
    .paginate_button
    {
        margin: 10px;
    }
</style>


@if(isset($message))
    <div id="msg" style="width:100%; background-color: green; color:white; text-align: center">{{$message}}</div>
@endif

<div class="row" style="margin-top: 100px">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h2>Competitions</h2>
            <hr/>
            <a href="{{URL::route('allCompetitions')}}">New Competition</a>
            <table id="competitionTable" class="table table-striped table-bordered footable">
                <thead>
                    <tr>
                        <th>Identification Number</th>
                        <th>Name</th>
                        <th>Arabic Name</th>
                        <th>Number Of Teams</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                </thead>

                <tfoot style="display:none">
                    <tr>
                        <th>Identification Number</th>
                        <th>Name</th>
                        <th>Arabic Name</th>
                        <th>Number Of Teams</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                </tfoot>
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
        $('#competitionTable').dataTable({
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
                "url": "{{URL::route('allCompetitions')}}",
                "dataSrc": "",
        },
        columns: [
             { data: 'Id' },
             { data: 'Name' },
             { data: 'ArName' },
             { data: 'NumberOfTeams' },
             { data: 'created_at' },
             { data: 'updated_at' }
        ],
        columnDefs: [
           {
               "render": function (data, type, row) {
                    return '<a href="/hub/public/players/editView/'+row['id']+'" title="Edit"><img src="{{URL::asset('assets/images/edit.png')}}" width="30px" /></a> | ' +
                   '<a href="#" onclick="RemoveUser(' + row['id'] + '); return false; " title="Delete"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a> | ' +
                   '<a href="{{url('/')}}/competition/'+row['Id']+'" title="Show Information"><img src="{{URL::asset('assets/images/info.png')}}" width="30px"/></a> | <a onclick="getSeason()" title="Start Round"><img src="{{URL::asset('assets/images/info.png')}}" width="30px"/></a>';

               }, "targets": 6
           }
        ]

    });
    }

    $(function () {
        $('#competitionTable').on('draw.dt', function () {
            $('.footable').footable({
                breakpoints: {
                    phone: 480,
                    tablet: 800
                }
            });
        });
        getUsers();
    });


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
    function getSeason() {
        var chk = confirm('Sure to start?');
        if (chk == true) {
            $.ajax({
                    url: "{{ route('getRound') }}",
                    dataSrc: "",
                    data: "",
                    type:'POST',
                    success: function(data){
                        console.log(data);
                    },
            });
        }
    }
    </script>
@endsection