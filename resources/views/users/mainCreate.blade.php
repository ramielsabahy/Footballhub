@extends('layouts.main')

@section('content')
<div class="container"  style="margin-top: 150px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading" style="color: white">@yield('heading')</div>

                <div class="panel-body">
                    {!! Form::open(array('url' => '/admins/create', 'data-parsley-validate' => '')) !!}
                        <div class="form-horizontal">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="fullName">FULL NAME</label>
                                <div class="col-md-10">
                                    {!! Form::text('fullName', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'FULL NAME',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'fullName',
                                        'data-parsley-required-message' => 'FULLNAME is required',
                                        'data-parsley-trigger'          => 'change focusout'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="name">USER NAME</label>
                                <div class="col-md-10">
                                    {!! Form::text('name', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'USER NAME',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'name',
                                        'data-parsley-required-message' => 'USERNAME is required',
                                        'data-parsley-trigger'          => 'change focusout'
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
                                        'data-parsley-type'             => 'email'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="password">PASSWORD</label>
                                <div class="col-md-10">
                                    <input class="field form-control" name="password" id="password" type="password" value="", required, data-parsley-required="",
                                    data-parsley-trigger="change focusout" placeholder="PASSWORD">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="mobileNumber">MOBILE NUMBER</label>
                                <div class="col-md-10">
                                    {!! Form::text('mobileNumber', null, [
                                        'class'                         => 'form-control',
                                        'placeholder'                   => 'MOBILE NUMBER',
                                        'required',
                                        'data-parsley-required'         => '',
                                        'id'                            => 'mobileNumber',
                                        'data-parsley-required-message' => 'MOBILE NUMBER is required',
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