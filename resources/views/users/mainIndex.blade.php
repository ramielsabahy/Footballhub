@extends('layouts.main')

@section('content')

<style type="text/css">
    .paginate_button
    {
        margin: 10px;
    }
</style>

@yield('heading')

@if(isset($message))
    <div id="msg" style="width:100%; background-color: green; color:white; text-align: center">{{$message}}</div>
@endif

<div class="row" style="margin-top: 100px">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            @yield('addHeading')
            <table id="usersTable" class="table table-striped table-bordered footable">
                <thead>
                    <tr>
                        <th>Identification Number</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>

                <tfoot style="display:none">
                    <tr>
                        <th>Identification Number</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection