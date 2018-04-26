@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row" style="margin-top: 150px">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Edit Report</h3></div>

                <div class="panel-body">
                    {!! Form::open(array('url' => '/cpanel/reports/editReport', 'data-parsley-validate' => '')) !!}
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="type">Type</label>
                                <div class="col-md-10">
                                    {!! Form::text('type', $report->type, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'Type',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'type',
                                        'data-parsley-required-message' => 'Type is required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="description">Description</label>
                                <textarea id="description" class="form-control col-md-12" placeholder="Description Here..." required data-parsley-required='', data-parsley-required-message='Description is required', data-parsley-trigger='change focusout' rows="5">
                                    {!!$report->description!!}
                                </textarea>
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

                 var wrapper = {
                   type: $('#type').val(), description: $('#description').val(), report_id: {!!$report->id!!}, user_id: {{Auth::user()->id}}
                 };
                $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                          .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                $.ajax({url: "{!!URL::route('editReport')!!}", type:'POST'
                    , data: wrapper
                    , success: function(result){
                          $('button').attr('disabled', false);
                          if (result.Statu) {
                              setPopup(result.Message, 'green', 1500);
                          }
                          else {
                              setPopup(result.Message, '#DD0B0B', 1500);
                          }
                          $(':input[type="submit"]').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection