@extends('layouts.main')

@section('content')

<style type="text/css">
    .paginate_button
    {
        margin: 10px;
    }
</style>

<h2>General Feed #{{ $feed->id }} Reports</h2>
<hr/>

@if(isset($message))
    <div id="msg" style="width:100%; background-color: green; color:white; text-align: center">{{$message}}</div>
@endif

<div class="row" style="margin-top: 100px">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="feedReportsTable" class="table table-striped table-bordered footable">
                <thead>
                    <tr>
                        <th class="col-md-1">Report Type</th>
                        <th class="col-md-1">Report Description</th>
                        <th class="col-md-1">Reporting User</th>
                        <th class="col-md-1">Reported Feed Content</th>
                        <th class="col-md-1">Reported Feed Thumbnail</th>
                        <th class="col-md-1">Feed Report Created At</th>
                        <th class="col-md-1">Delete The General Feed</th>         
                    </tr>
                </thead>
                <tbody id="feedReportsBody">

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    </script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}

        function getFeedReports() {
            $('select').attr('disabled', true);
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                        .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $('#feedReportsBody').empty();
            $('#feedReportsTable').css('display', 'inline-block');
            $.ajax(
                {
                    url: "{{URL::route('getFeedReports')}}",
                    type:'POST',
                    data: {feed_id: {{ $feed->id }}, user_id: {{Auth::user()->id}}},
                    success: function(result){
                        $('#err_Desc').fadeOut(300);
                        $('select').attr('disabled', false);
                        $.each(result.InnerData.feed_reports, function(index, feed_report) {
                            $('#feedReportsBody').append('<tr><td>'+feed_report.report.type+'</td><td>'+feed_report.report.description+'</td><td>'+feed_report.user.fullName+'</td><td>'+result.InnerData.body+'</td><td><img src="{!! url('/') !!}/storage/general_feeds/'+result.InnerData.thumbnail+'" class="thumbnail" style="width:100%;height:100%;"/></td><td>'+feed_report.feed.created_at+'</td><td><a href="#" onclick="RemoveGeneralFeed(' + result.InnerData.id + '); return false; " title="Delete General Feed"><img src="{{URL::asset('assets/images/delete.png')}}" width="30px" /></a></td></tr>');
                        });
                    }
                }
            );
        }
        window.onload = getFeedReports();

        function RemoveGeneralFeed(id) {
            var chk = confirm('Sure to delete?');
            if (chk == true) {
                $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                $.ajax({
                        url: "{{URL::route('generalFeedDestroy')}}",
                        dataSrc: "",
                        data: {'id': id, 'user_id': "{{Auth::user()->id}}"},
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
            var APP_URL = {!! json_encode(url('/')) !!};
            window.location.replace(APP_URL+'/generalFeeds/indexView');
        }
    </script>
@endsection