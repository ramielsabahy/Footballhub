@extends('layouts.main')

@section('content')
<link href="{{URL::asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Terms and Conditions</div>
                <div class="panel-body">
					{!! Form::open(array('action' => 'TermsAndConditionsController@setTermsAndConditions', 'data-parsley-validate' => '', 'method' => 'POST')) !!}
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="termsandconditions">Terms and Conditions</label>
                                <div class="col-md-10">
                                    {!! Form::textarea('termsandconditions', $termsAndConditions, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'Terms and Conditions',
                                        'id'                            => 'termsandconditions',
                                        'required',
                                        'data-parsley-required-message' => 'Terms and Conditions are required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <input type="submit" value="Update" class="btn btn-info" />
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
    <script src="{{URL::asset('assets/summernote/summernote-bs4.js')}}" type="text/javascript" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.js"></script>
    <script>
          var content = '';
          $('#termsandconditions').summernote({
            placeholder: 'Terms and Conditions',
            tabsize: 2,
            height: 100,
                callbacks: {
                    onChange: function(contents) {
                        content = contents;
                    }
                }
          });
    </script>
    <script type="text/javascript">
        $(function () {
            $(document).on("submit", "form", function(e){
                e.preventDefault();
                $('button').attr('disabled', true);
                $(':input[type="submit"]').prop('disabled', true);

                var wrapper = {
                    termsandconditions:content
                };
                $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                          .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                $.ajax({url: "{!!URL::route('setTermsAndConditions')!!}", type:'POST'
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
            });
        });
    </script>
@endsection