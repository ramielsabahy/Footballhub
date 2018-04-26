@extends('layouts.main')

@section('content')
    <div class="row" style="margin-top: 150px">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if ($exists)
                    <div class="panel-heading">Terms and Conditions</div>
                    <div class="panel-body">
                        {!!$termsAndConditions!!}
                    </div>
                    <div class="panel-footer">
                        <a href="{{ URL::route('updateTermsAndConditions') }}" class="btn btn-success btn-md">Update Terms and Conditions</a>
                    </div>
                @else
                    <div class="panel-heading">Terms and Conditions</div>
                    <div class="panel-body">
                        <a href="{{ URL::route('createTermsAndConditions') }}" class="btn btn-success btn-md">Create Terms and Conditions</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection