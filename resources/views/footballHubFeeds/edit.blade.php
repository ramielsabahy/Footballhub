@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row" style="margin-top: 150px">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-color panel-info">
                <div class="panel-heading"><h3 style="color: white">Edit Football Hub Feed</h3></div>

                <div class="panel-body">
                    {!! Form::open(array('url' => '/football_hub_feeds_cms/edit', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data')) !!}
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="body">Body</label>
{{--
                                <div class="col-md-10">
                                    {!! Form::text('body', $footballHubFeed->body, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'Body',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'body',
                                        'data-parsley-required-message' => 'Body is required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
--}}
                              <div class="col-md-10">
                                <textarea class="form-control" name="body" placeholder="Add a comment" id="comment" rows="5">{{$footballHubFeed->body}}</textarea>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="thumbnail">Image</label>
                                <div class="col-md-10">
                                    {!! Form::file('thumbnail', ['id' => 'thumbnail']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <input type="submit" value="Edit" class="btn btn-info" />
                                </div>
                            </div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
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
        $(function () {
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

            $(document).on("submit", "form", function(e){
                e.preventDefault();
                $('button').attr('disabled', true);
                $(':input[type="submit"]').prop('disabled', true);

                function getBase64(file) {
                   var reader = new FileReader();
                   reader.readAsDataURL(file);
                   reader.onload = function () {
                     var wrapper = {
                       body: $('#body').val(), thumbnail: reader.result, user_id: {{Auth::user()->id}}, id: {{ $footballHubFeed->id }}
                     };
                    $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                              .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                    $.ajax({url: "{!!URL::route('footballHubFeedEdit')!!}", type:'POST'
                        , data: wrapper
                        , success: function(result){
                              $('button').attr('disabled', false);
                              if (result.Status) {
                                  setPopup(result.Message, 'green', 1500);
                              }
                              else {
                                  setPopup(result.Message, '#DD0B0B', 1500);
                              }
                              $(':input[type="submit"]').prop('disabled', false);
                        }
                    });
                   };
                   reader.onerror = function (error) {
                     var wrapper = {
                       body: $('#body').val(), thumbnail: null, user_id: {{Auth::user()->id}}, id: {{ $footballHubFeed->id }}
                     };
                   };
                }
                if ($('#thumbnail').val().length) {
                    var file = $('#thumbnail')[0]['files'][0];
                    getBase64(file);
                } else {
                     var wrapper = {
                       body: $('#body').val(), thumbnail: null, user_id: {{Auth::user()->id}}, id: {{ $footballHubFeed->id }}
                     };
                    $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                              .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                    $.ajax({url: "{!!URL::route('footballHubFeedEdit')!!}", type:'POST'
                        , data: wrapper
                        , success: function(result){
                              $('button').attr('disabled', false);
                              if (result.Status) {
                                  setPopup(result.Message, 'green', 1500);
                              }
                              else {
                                  setPopup(result.Message, '#DD0B0B', 1500);
                              }
                              $(':input[type="submit"]').prop('disabled', false);
                        }
                    });
                }

            });
        });
    </script>
@endsection