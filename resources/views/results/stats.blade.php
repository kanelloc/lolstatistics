@extends('layouts.default')
    @section('content')
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header"><strong><i>{{ $username }}</i></strong></section>
            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="{{url('http://ddragon.leagueoflegends.com/cdn/7.14.1/img/profileicon/'.$profileIconId.'.png')}}" alt="User profile picture">
                                    <h3 class="profile-username text-center">{{$profileIconId}}</h3>
                                    <p class="text-muted text-center">Software Engineer</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Account Id</b>
                                            <a class="pull-right">{{$account_id}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Followers</b>
                                            <a class="pull-right">1,322</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Followers</b>
                                            <a class="pull-right">1,322</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Ranked</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong><p align="center">{{$tier_solo}} {{$rank_solo}}</p></strong>
                                            <img class="img-responsive" src="{{url('/images'.'/'.$imagesrc_solo)}}" alt="Image"/>
                                            <strong><p align="center">Ranked solo</p></strong>
                                            <p align="center">{{$leagueName_solo}}</p>   
                                        </div>
                                        <div class="col-md-9">
                                            <p>W{{$wins_solo}}/L{{$losses_solo}}</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$win_rate_solo}}%">Won
                                                </div>
                                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: {{$lost_rate_solo}}%">Lost
                                                </div>
                                            </div>
                                            <p>LP: {{$leaguePoints_solo}}</p>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-primary" style="width: {{$leaguePoints_solo}}%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                  <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                            <p class="text-green">Success rate: {{$win_rate_solo}}%</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong><p align="center">{{$tier_flex}} {{$rank_flex}}</p></strong>
                                            <img class="img-responsive" src="{{url('/images'.'/'.$imagesrc_flex)}}" alt="Image"/>
                                            <strong><p align="center">Ranked Flex</p></strong>
                                            <p align="center">{{$leagueName_flex}}</p> 
                                        </div>
                                        <div class="col-md-9">
                                            <p>W{{$wins_flex}}/L{{$losses_flex}}</p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$win_rate_flex}}%">Won
                                                </div>
                                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: {{$lost_rate_flex}}%">Lost
                                                </div>
                                            </div>
                                            <p>LP: {{$leaguePoints_flex}}</p>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-green" style="width: {{$leaguePoints_flex}}%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                  <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Statistics</h3>

                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#overall">Overall</a></li>
                                            <li><a data-toggle="tab" href="#ranked_solo">Solo Ranked</a></li>
                                            <li><a data-toggle="tab" href="#ranked_flex">Ranked Flex</a></li>
                                        </ul>


                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="box-body tab-content">
                                        <div id="overall" class="tab-pane fade in active">
                                            <p>Overall</p>
                                        </div>
                                        <div id="ranked_solo" class="tab-pane fade ">
                                            <p>Ranked solo</p>
                                        </div>
                                        <div id="ranked_flex" class="tab-pane fade ">
                                            <p>Ranked flex</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($matches as $match)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class='profile-user-img img-responsive img-circle' src="{{url('https://ddragon.leagueoflegends.com/cdn/7.14.1/img/champion/'.$match->champion_name.'.png')}}" alt="Image">
                                            </div>
                                            <div class="col-md-3">
                                                <h3 class="box-title">{{$match->gameId}}</h3>
                                            </div>
                                        </div>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <p>ASFKNMALSJKFN</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>   
                </div>
            </section> 
        </div>
    </div>
@stop