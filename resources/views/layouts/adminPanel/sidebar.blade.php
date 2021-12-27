<div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                <!-- END SIDEBAR TOGGLER BUTTON -->
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    {{-- <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                        <a href="javascript:;" class="remove">
                            <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form> --}}
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                {{-- <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start active open">
                            <a href="index.html" class="nav-link ">
                                <i class="icon-bar-chart"></i>
                                <i class="icon-bulb"></i>
                                <span class="title">Dashboard 1</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="dashboard_2.html" class="nav-link ">
                                <span class="title">Dashboard 2</span>
                                <span class="badge badge-success">1</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="dashboard_3.html" class="nav-link ">
                                <i class="icon-graph"></i>
                                <span class="title">Dashboard 3</span>
                                <span class="badge badge-danger">5</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="heading">
                    {{-- <h3 class="uppercase">Features</h3> --}}
                </li>
                <li class="nav-item">
                    <a href="{{url('/admin')}}" class="nav-link">
                        <i class="icon-home"></i>
                        <span class="title">الرئيسية</span>
                    </a>
                </li>
                @if (Auth::user()->can('view reports'))
                 <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-file-text-o"></i>
                        <span class="title">التقارير</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add categories')
                            <li class="nav-item">
                                <a href="{{route('reports.orders')}}" class="nav-link ">
                                    <i class="fa fa-file-text-o"></i>
                                    <span class="title">تقرير الاوردرات</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li> 
                @endif

                {{-- @if (Auth::user()->can('add categories') || Auth::user()->can('view categories'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">{{Translator::get('categories')}}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add categories')
                        <li class="nav-item  ">
                            <a href="{{route('categories.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">{{Translator::get('add_category')}}</span>
                            </a>
                        </li>
                        @endcan

                        @can('view categories')
                        <li class="nav-item  ">
                            <a href="{{route('categories.index')}}" class="nav-link ">
                                <span class="title">{{Translator::get('all_categories')}}</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('add places') || Auth::user()->can('view places'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-map-o"></i>
                        <span class="title">المدن</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add places')
                        <li class="nav-item">
                            <a href="{{route('place.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة مدينة</span>
                            </a>
                        </li>
                        @endcan
                        @can('view places')
                        <li class="nav-item  ">
                            <a href="{{route('place.index')}}" class="nav-link ">
                                <span class="title">كل المدن</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('add cities') || Auth::user()->can('view cities'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">الاماكن</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add cities')
                        <li class="nav-item  ">
                            <a href="{{route('city.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة مكان</span>
                            </a>
                        </li>
                        @endcan
                        @can('view cities')
                        <li class="nav-item  ">
                            <a href="{{route('city.index')}}" class="nav-link ">
                                <span class="title">كل الاماكن</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif --}}

                @if (Auth::user()->can('add resturants') || Auth::user()->can('view resturants'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cutlery"></i>
                        <span class="title">المطاعم</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        @can('add resturants')
                        <li class="nav-item  ">
                            <a href="{{route('resturants.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة مطعم</span>
                            </a>
                        </li>
                        @endcan
                        @can('view resturants')
                        <li class="nav-item  ">
                            <a href="{{route('resturants.index')}}" class="nav-link ">
                                <span class="title">المطاعم</span>
                            </a>
                        </li>
                        {{--
                        <li class="nav-item  ">
                            <a href="{{route('resturants.sortAll')}}" class="nav-link ">
                                <i class="fa fa-list-ol"></i>
                                <span class="title">ترتيب اولوية ظهور المطاعم فى كل المطاعم</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('resturants.sortChoosen')}}" class="nav-link ">
                                <i class="fa fa-list-ol"></i>
                                <span class="title">ترتيب اولوية ظهور المطاعم فى اخترنا لك</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('resturants.sortOffers')}}" class="nav-link ">
                                <i class="fa fa-list-ol"></i>
                                <span class="title">ترتيب اولوية ظهور المطاعم فى العروض</span>
                            </a>
                        </li> --}}
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('view rates'))
                {{-- <li class="nav-item">
                    <a href="{{route('resturants.reviews')}}" class="nav-link">
                        <i class="fa fa-star"></i>
                        <span class="title">تقييمات العملاء للمطاعم</span>
                    </a>
                </li> --}}
                @endif
                @if (Auth::user()->can('add products') || Auth::user()->can('view products'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cube"></i>
                        <span class="title">المنتجات</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add products')
                        <li class="nav-item">
                            <a href="{{route('items.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة منتج</span>
                            </a>
                        </li>
                        @endcan
                        @can('view products')
                        <li class="nav-item  ">
                            <a href="{{route('items.index')}}" class="nav-link ">
                                <span class="title">كل المنتجات</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('add resturant owners') || Auth::user()->can('view resturant owners'))
                {{-- <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user"></i>
                        <span class="title">{{Translator::get('resturant_owners')}}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add resturant owners')
                        <li class="nav-item">
                            <a href="{{route('resturantOwners.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">{{Translator::get('add_resturant_owner')}}</span>
                            </a>
                        </li>
                        @endcan
                        @can('view resturant owners')
                        <li class="nav-item  ">
                            <a href="{{route('resturantOwners.index')}}" class="nav-link ">
                                <span class="title">{{Translator::get('all_resturant_owners_accounts')}}</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li> --}}
                @endif
                @if (Auth::user()->can('add employees') || Auth::user()->can('view employees'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title">الموظفين</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add employees')
                        <li class="nav-item  ">
                            <a href="{{route('employee.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة موظف</span>
                            </a>
                        </li>
                        @endcan
                        @can('view employees')
                        <li class="nav-item  ">
                            <a href="{{route('employee.index')}}" class="nav-link ">
                                <i class="fa fa-users"></i>
                                <span class="title">كل الموظفين</span>
                            </a>
                        </li>
                        @endcan
                        @if (Auth::user()->can('add roles') || Auth::user()->can('view roles'))
                        <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-users"></i>
                            <span class="title">مجموعات المستخدمين</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            @can('add roles')
                            <li class="nav-item  ">
                                <a href="{{route('employee.roles.create')}}" class="nav-link ">
                                    <i class="fa fa-plus"></i>
                                    <span class="title"> اضافة مجموعة</span>
                                </a>
                            </li>
                            @endcan
                            @can('view roles')
                            <li class="nav-item  ">
                                <a href="{{route('employee.roles.index')}}" class="nav-link ">
                                    <i class="fa fa-users"></i>
                                    <span class="title"> كل المجموعات</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endif
                            
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('add waiters') || Auth::user()->can('view waiters'))
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title">waiters</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add waiters')
                        <li class="nav-item">
                            <a href="{{route('waiter.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">waiter اضافه </span>
                            </a>
                        </li>
                        @endcan
                        @can('view waiters')
                        <li class="nav-item  ">
                            <a href="{{route('waiter.index')}}" class="nav-link ">
                                <span class="title"> waiters كل</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('add feedback reasons') || Auth::user()->can('view feedback reasons'))
                {{-- <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-warning"></i>
                        <span class="title">اسباب التعليقات و الشكاوى</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('add feedback reasons')
                        <li class="nav-item">
                            <a href="{{route('userFeedbackReason.create')}}" class="nav-link ">
                                <i class="fa fa-plus"></i>
                                <span class="title">اضافة سبب التعليق او الشكوى</span>
                            </a>
                        </li>
                        @endcan
                        @can('view feedback reasons')
                        <li class="nav-item  ">
                            <a href="{{route('userFeedbackReason.index')}}" class="nav-link ">
                                <span class="title">اسباب التعليقات و الشكاوى</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li> --}}
                @endif

                @if (Auth::user()->can('view orders'))
                {{-- <li class="nav-item">
                    <li class="nav-item  ">
                        <a href="{{route('orders.index')}}" class="nav-link ">
                            <i class="fa fa-list"></i>
                            <span class="title">الاوردرات</span>
                        </a>
                    </li>
                </li>

                <li class="nav-item">
                    <li class="nav-item  ">
                        <a href="{{route('orders.indexPage')}}" class="nav-link ">
                            <i class="fa fa-list"></i>
                            <span class="title">الاوردرات المنتهية</span>
                        </a>
                    </li>
                </li> --}}
                @endif

                @if (Auth::user()->can('send notification messages'))
                {{-- <li class="nav-item">
                    <li class="nav-item  ">
                        <a href="{{route('notifications.create')}}" class="nav-link ">
                            <i class="fa fa-bullhorn"></i>
                            <span class="title">ارسال تنبيه للمستخدمين</span>
                        </a>
                    </li>
                </li> --}}
                @endif

                @if (Auth::user()->can('view feedback messages'))
                {{-- <li class="nav-item">
                    <a href="{{route('feedbacks.index')}}" class="nav-link">
                        <i class="icon-envelope"></i>
                        <span class="title">رسائل المستخدمين</span>
                    </a>
                </li> --}}
                @endif


                @if (Auth::user()->can('view terms'))
                {{-- <li class="nav-item">
                    <a href="{{route('terms.view')}}" class="nav-link">
                        <i class="fa fa-list"></i>
                        <span class="title">الشروط و الاحكام</span>
                    </a>
                </li> --}}
                @endif
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
