@php

$code_lang  =  session('cmslangcode');

$lang_dir = 'cmsdir.'.$code_lang;

$style_dir = config($lang_dir);
if($style_dir == NULL)
{
    $style_dir = 'rtl';
}
$date=date('Y-m-d h:i:sa');
@endphp
<!DOCTYPE html>

@if($style_dir=='rtl')
<html lang="en" dir="rtl">
@else
<html lang="en" dir="ltr">
@endif
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8"/>
        <title>Venu Dashboard</title>
        <meta name="csrf_token" content="{{csrf_token()}}">

        @if($style_dir=='rtl')

            @include('layouts.adminPanel.styleRTL')


        @elseif($style_dir=='ltr')

            @include('layouts.adminPanel.styleLTR')

        @endif
        <link href="{{asset('assets/global/plugins/ladda/ladda-themeless.min.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('time').innerHTML =
                    h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        </script>
        @yield('styles')
    </head>
    <!-- END HEAD -->

    <body onload="startTime()" class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="{{url('/admin')}}">
                        {{-- <img src="{{asset('assets/layouts/layout/img/logo.jpeg')}}" style="margin: 0px;width: 50px;padding: 5px" alt="logo"  /> --}}

                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">

                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                        <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                        <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN INBOX DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                        <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">

                            {{-- <a href="javascript:;"  class="dropdown-toggle"
                                data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-envelope-open"></i>

                            </a> --}}
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3>
                                        <span class="bold"></span></h3>
                                </li>

                                <li>
                                    <ul id="notifications_list" class="dropdown-menu-list scroller" style="height: 275px;"
                                        data-handle-color="#637283">

                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <!-- END INBOX DROPDOWN -->
                        <!-- BEGIN TODO DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                        <li class="separator hide"></li>

                            {{-- <li class="dropdown dropdown-language">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                    <span class="langname"> ar</span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                        <li>
                                            <a > test</a>
                                        </li>
                                </ul>
                            </li> --}}
                        {{-- <li class="dropdown dropdown-language">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                <img alt="" src="{{url('/')}}/public/a.png">
                                <span class="langname"> English <i class="fa fa-language"></i></span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">

                                    <li>
                                        <a href="#">
                                            <img alt=""
                                                    > English
                                        </a>
                                    </li>

                            </ul>
                        </li> --}}
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown" data-close-others="true">

                        <span class="username username-hide-on-mobile">
                            @if (Auth::guest())
                            @else

                                {{ Auth::user()->name }}
                            @endif

                        </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                        {{csrf_field()}}
                                    </form>
                                </li>


                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"></div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
        @include('layouts.adminPanel.sidebar')
        <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <div class="page-toolbar">

                                <i class="icon-calendar" id="time"></i>



                        </div>
                    </div>
                @yield('content')
                <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                {{-- <div class="page-footer-inner"> 2016 &copy; Metronic Theme By
                    <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
                    <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes"
                        title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase
                        Metronic!</a>
                </div> --}}
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
        <script src="../assets/global/plugins/respond.min.js"></script>
        <script src="../assets/global/plugins/excanvas.min.js"></script>
        <script src="../assets/global/plugins/ie8.fix.min.js"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->

        <!-- END THEME LAYOUT SCRIPTS -->
        @include('layouts.adminPanel.scripts')
        <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        </script>
        @include('layouts.adminPanel.js.sweetalert')
    @yield('javascript')

    </body>

</html>
