@extends('layouts.adminPanel.admin')
@section('content')
<h1 class="page-title"> Admin Dashboard
    <small>statistics, charts, recent events and reports</small>
</h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{$TodayOrdrersNum}}">0</span>
                </div>
                <div class="desc"> Today Orders </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{$OrdrersNum}}">{{$OrdrersNum}}</span> </div>
                <div class="desc"> Total Ordars </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{$androidUsersNum}}">0</span>
                </div>
                <div class="desc"> Android Users </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{$iosUsersNum}}">0</span> </div>
                <div class="desc"> Ios Users </div>
            </div>
        </a>
    </div>
</div>
<div class="clearfix"></div>
@endsection
