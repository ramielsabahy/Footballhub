@extends('layouts.main')

@section('content')

<style type="text/css">
    .paginate_button
    {
        margin: 10px;
    }
</style>

<h2>Reports</h2>
<hr/>

@if(isset($message))
    <div id="msg" style="width:100%; background-color: green; color:white; text-align: center">{{$message}}</div>
@endif

<div class="row" style="margin-top: 100px">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <a href="{{URL::route('createReportView')}}">New Report</a>
            <table id="reportsTable" class="table table-striped table-bordered footable">
                <thead>
                    <tr>
                        <th>Identification Number</th>
                        <th>Report Type</th>
                        <th>Report Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                </thead>

                <tfoot style="display:none">
                    <tr>
                        <th>Identification Number</th>
                        <th>Report Type</th>
                        <th>Report Description</th>
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

    function getReports() {
        $('#reportsTable').dataTable({
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
                "url": "{{URL::route('getReportsDataTable')}}",
                "dataSrc": "",
        },
        columns: [
             { data: 'id' },
             { data: 'type' },
             { data: 'description' },
             { data: 'created_at' },
             { data: 'updated_at' }
        ],
        columnDefs: [
           {
               "render": function (data, type, row) {
                    return '<a href="#" onclick="RemoveReport(' + row['id'] + '); return false; " title="Delete"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a><br/><br/>' + '<a href="/cpanel/reports/editReport/' + row['id'] + '" title="Edit"><img src="{{URL::asset('assets/images/edit.png')}}" width="30px" /></a><br/><br/>' + '<a href="/cpanel/reports/indexReportFeeds/' + row['id'] + '" title="Report Feeds"><img src="{{URL::asset('assets/images/post.png')}}" width="30px" /></a>';

               }, "targets": 5
           }
        ]

    });
    }

    $(function () {
        $('#reportsTable').on('draw.dt', function () {
            $('.footable').footable({
                breakpoints: {
                    phone: 480,
                    tablet: 800
                }
            });
        });
        getReports();
    });

    function RemoveReport(id) {
        var chk = confirm('Sure to delete?');
        if (chk == true) {
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $.ajax({
                    url: "{{URL::route('destroyReport')}}",
                    dataSrc: "",
                    data: {'report_id': id, 'user_id': "{{Auth::user()->id}}"},
                    type:'POST',
                    success: OnRequestCompleted
                    , error: function(xhr, textStatus, errorThrown){
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);
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
        location.reload();
        getReports();
    }
    </script>
@endsection