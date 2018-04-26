@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@yield('heading')</div>

                <div class="panel-body">
                    {!! Form::open(array('url' => '/admins/create', 'data-parsley-validate' => '')) !!}
                        <div class="form-horizontal">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="weight">WEIGHT</label>
                                <div class="col-md-10">
                                    {!! Form::number('weight', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'WEIGHT',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'weight',
                                        'data-parsley-required-message' => 'WEIGHT is required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="height">HEIGHT</label>
                                <div class="col-md-10">
                                    {!! Form::number('height', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'HEIGHT',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'height',
                                        'data-parsley-required-message' => 'HEIGHT is required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="birth">BIRTH</label>
                                <div class="col-md-10">
                                    {!! Form::date('birth', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'BIRTH',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'birth',
                                        'data-parsley-required-message' => 'BIRTH is required',
                                        'data-parsley-trigger'          => 'change focusout',
                                        'data-parsley-type'             => 'date'
                                    ]) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-2" for="email">EMAIL</label>
                                <div class="col-md-10">
                                    {!! Form::email('email', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'EMAIL',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'email',
                                        'data-parsley-required-message' => 'EMAIL is required',
                                        'data-parsley-trigger'          => 'change focusout',
                                        'data-parsley-type'             => 'digits'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <input type="submit" value="Create" class="btn btn-info" />
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