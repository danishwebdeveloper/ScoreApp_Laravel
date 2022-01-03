<div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="javascript:void(0);">
                        <h5 style="color: #FFF" class="logo-default">TALENT RANKER</h5>
                        <!-- <img src="{{ asset('web/assets/layouts/layout2/img/logo-default.png') }}" alt="logo" class="logo-default" /> -->
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    @if(!empty(Auth::user()->profile_image))
                                    <img alt="" class="img-circle" src="{{ asset('web/assets/uploads/user_images/'.Auth::user()->profile_image) }}" />
                                    @else
                                    <img alt="" class="img-circle" src="{{ asset('web/assets/layouts/layout2/img/avatar3_small.jpg') }}" />
                                    @endif
                                    <span class="username username-hide-on-mobile"> {{ Auth::user()->first_name." ".Auth::user()->last_name }} </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <!-- <li>
                                        <a href="page_user_profile_1.html">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li>
                                        <a href="app_calendar.html">
                                            <i class="icon-calendar"></i> My Calendar </a>
                                    </li>
                                    <li>
                                        <a href="app_inbox.html">
                                            <i class="icon-envelope-open"></i> My Inbox
                                            <span class="badge badge-danger"> 3 </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="app_todo_2.html">
                                            <i class="icon-rocket"></i> My Tasks
                                            <span class="badge badge-success"> 7 </span>
                                        </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="page_user_lock_1.html">
                                            <i class="icon-lock"></i> Lock Screen </a>
                                    </li> -->
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="icon-key"></i> {{ ling('logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            @php
                                $langs = load_languages();
                                $lang_info = lang_info(Session::get('lang'));
                            @endphp
                            @if(!empty($langs))
                            <li class="dropdown dropdown-language">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" src="{{ asset('web/assets/uploads/assets/'.$lang_info->icon) }}">
                                    <span class="langname"> {{ strtoupper($lang_info->locale) }} </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    @foreach($langs as $key => $lang)
                                    <li>
                                        <a href="javascript:void(0);" onclick="change_lang('{{ $lang->locale }}')">
                                            <img alt="" src="{{ asset('web/assets/uploads/assets/'.$lang->icon) }}"> 
                                            {{ $lang->name }} 
                                        </a>
                                    </li>
                                    @endforeach
                                    <!-- Change Default Language -->
                                    <li style="border-bottom: 1px dotted #cfcfcf"></li>
                                    <li><a href="javascript:void(0);" data-target="#defLang" data-toggle="modal"><i class="fa fa-language"></i> {{ ling('change_default_language') }}</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>