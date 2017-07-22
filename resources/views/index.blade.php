@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search for a Lol player</div>
                <div class="panel-body">
                    <form action="{{ route('home.results')}}" method="POST" class="form-horizontal">

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="usernameSearch" class="form-control" id="usernameSearch">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{Session::token()}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop