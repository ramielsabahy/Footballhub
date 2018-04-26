@extends('users.mainEdit')

@section('heading')
    <h3>Edit Referee</h3>
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
          $(document).on("submit", "form", function(e){
              e.preventDefault();
              $('button').attr('disabled', true);
              $(':input[type="submit"]').prop('disabled', true);
    
              var wrapper = {
                  fullName:$('#fullName').val(), name: $('#name').val(), email: $('#email').val(), password: $('#password').val(), mobileNumber:$('#mobileNumber').val(), id:"{{$user->id}}", user_id: {{Auth::user()->id}}
              };
                  
              $('#err_Desc').html('<img src="{{URL::asset('assets/images/wait.png')}}" />' + '&nbsp;&nbsp;' + '<img src="{{URL::asset('assets/images/ellipsis.gif')}}" />')
                            .css({ 'background-color': '#171B21', 'padding': '10px' }).fadeIn(400);
                    
              $.ajax({url: "{!!URL::route('editReferee')!!}", type:'POST'
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