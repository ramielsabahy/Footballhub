@extends('layouts.main')

@section('content')
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">People liked this post</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3 class="control-label">
                                @foreach($users as $user)
                                    <?php
                                        $like = \App\User::findOrFail($user->user_id);
                                    ?>
                                    {{ $like->name }}
                                    <br>
                                @endforeach
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Play Video</h4>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="315" src="{{ $feed->thumbnail }}"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <div class="row" style="margin-top: 150px">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-color panel-info">
                <div class="panel-heading" style="color: white">
                    <h3 style="color:white">General Feed #{{ $feed->id }}</h3>
                    Created {{ $feed->created_at->diffForHumans() }}
                    <br/>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($feed->feed_type == 1)
                            <img src="{!! url('/') !!}/storage/general_feeds/{{ $feed->thumbnail }}" class="thumbnail" style="width:100%;height:100%;"/>
                            @elseif($feed->feed_type == 2)
                            <span>{{ $feed->body }}</span>
                            @else
                            <iframe width="100%" height="315" src="{{ $feed->thumbnail }}"></iframe>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="margin-top: 50px;">
                        <div class="col-md-12">
                            {{ $feed->body }}
                            <hr/>
                            <div id="countLikes"></div>
                            <textarea class="form-control" name="body" placeholder="Add a comment" id="comment" rows="5"></textarea>
                            <hr/>
                            <strong>Comments</strong>
                            <hr/>
                            <div id="comments"></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    Created By {{ $feed->user->fullName }} at {{ $feed->user->created_at }}
                    <hr/>
                    <a href="#" onclick="RemoveGeneralFeed({{ $feed->id }}); return false; " title="Delete">
                        <img src="{{URL::asset('assets/images/delete.png')}}" width="30px" />
                    </a>
                    |
                    <a href="/cpanel/reports/indexFeedReports/{{ $feed->id }}" title="View">
                        <img src="{{URL::asset('assets/images/Reports.png')}}" width="30px" />
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
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
            setPopup(resposne.Message, 'green', 1500);
        }
        else {
            setPopup(response.Message, '#DD0B0B', 1500);
        }
        $('#err_Desc').fadeOut(300);
        $('#sumbitBtn').attr('disbaled', false);
        var APP_URL = {!! json_encode(url('/')) !!};
        window.location.replace(APP_URL+'/generalFeeds/indexView');
    }

    function RemoveComment(id) {
        var chk = confirm('Sure to delete?');
        if (chk == true) {
            $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
            $.ajax({
                    url: "{{URL::route('commentDestroy')}}",
                    dataSrc: "",
                    data: {'id': id, 'user_id': "{{Auth::user()->id}}"},
                    type:'POST',
                    success: function(result) {
                      $('button').attr('disabled', false);
                      if (result.Status) {
                          setPopup(result.Message, 'green', 1500);
                      }
                      else {
                          setPopup(result.Message, '#DD0B0B', 1500);
                      }
                      $(':input[type="submit"]').prop('disabled', false);
                      location.reload();
                    }
                    , error: function(xhr, textStatus, errorThrown){
                        console.log(textStatus);
                        console.log(errorThrown);
                        console.log(xhr);
                    }
            });
        }
    }

    // Listen for enter
    $(document).keypress(function(e) {
        if(e.which == 13) {
            addComment({{ $feed->id }});
        }
    });

    function flexibleTextArea() {
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);
                     
        function autosize(){
          var el = this.textarea;
          setTimeout(function(){
            el.style.cssText = 'height:auto; padding:0';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
          },0);
        }
    }
    flexibleTextArea();

    function countLikes() {
        $.ajax({
                url: "{{URL::route('countLikes')}}",
                dataSrc: "",
                data: {'id': "{{ $feed->id }}"},
                type:'POST',
                success: function(result) {
                    $('#countLikes').append(' <button class="btn btn-primary waves-effect waves-light" style="margin-bottom:20px" data-toggle="modal" data-target="#con-close-modal">'+result.InnerData+' Person like this post</button>');
                }
        });
    }
    countLikes();

    function addComment(feed_id) {
        $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
        if ($('#comment').val().length == 0) {
            alert('Please insert a comment, comment can\'t be empty');
            $('#err_Desc').fadeOut(300);
            $('#sumbitBtn').attr('disbaled', false);
            return ;
        }
        $.ajax({
                url: "{{URL::route('commentOnFeed')}}",
                dataSrc: "",
                data: {'feed_id': feed_id, 'user_id': "{{Auth::user()->id}}", comment: $('#comment').val()},
                type:'POST',
                success: function(result) {
                  $('#err_Desc').fadeOut(300);
                  $('#sumbitBtn').attr('disbaled', false);
                  $('button').attr('disabled', false);
                  if (result.Status) {
                      setPopup(result.Message, 'green', 1500);
                  }
                  else {
                      setPopup(result.Message, '#DD0B0B', 1500);
                  }
                  $(':input[type="submit"]').prop('disabled', false);
                  location.reload();
                }
                , error: function(xhr, textStatus, errorThrown){
                    console.log(textStatus);
                    console.log(errorThrown);
                    console.log(xhr);
                }
        });
    }

    function loadComments() {
        $('#err_Desc').html('<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />').css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
        $.ajax({
                url: "{{URL::route('feedComments')}}",
                dataSrc: "",
                data: {'id': "{{ $feed->id }}"},
                type:'POST',
                success: function(result) {
                    $('#err_Desc').fadeOut(300);
                    $('#sumbitBtn').attr('disbaled', false);
                    for(i in result) {
                        $('#comments').append('<div class="panel panel-default"><div class="panel-heading"><strong>'+result[i].user.fullName+'</strong><div class="pull-right"><a href="#"  onclick="RemoveComment(' + result[i].id + '); return false; " title="Delete"><i class="fa fa-close fa-2x" aria-hidden="true"></i></a></div><br/><small>'+result[i].created_at+'</small></div><div class="panel-body">'+result[i].comment+'</div></div>');
                    }
                }
                , error: function(xhr, textStatus, errorThrown){
                    console.log(xhr);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
        });
    }
    loadComments();
</script>
@endsection