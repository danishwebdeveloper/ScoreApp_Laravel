<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->

        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            
            <!-- Super Admin Access Menu -->
            @if(Auth::user()->isSuperAdmin())
            <li class="nav-item start {{ Request::is('admin_panel/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin_panel/dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ ling('dashboard') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin_panel/organizations', 'admin_panel/add_organization') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-building-o"></i>
                    <span class="title">{{ ling('organizations') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin_panel/add_organization') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/add_organization') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_org') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin_panel/organizations') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/organizations') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('org_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin_panel/add_team', 'admin_panel/teams') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ ling('teams') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin_panel/add_team') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/add_team') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_team') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin_panel/teams') ? 'active' : '' }}"">
                        <a href="{{ url('admin_panel/teams') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('teams_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin_panel/add_admin', 'admin_panel/admins') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-user-secret"></i>
                    <span class="title">{{ ling('admins') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin_panel/add_admin') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/add_admin') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_new_admin') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin_panel/admins') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/admins') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('admin_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin_panel/add_manager', 'admin_panel/managers_list') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-black-tie"></i>
                    <span class="title">{{ ling('managers') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin_panel/add_manager') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/add_manager') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_new_manager') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin_panel/managers_list') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/managers_list') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('managers_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin_panel/locales') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-language"></i>
                    <span class="title">{{ ling('languages') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin_panel/locales') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/locales') }}" class="nav-link ">
                            <i class="fa fa-flag"></i>
                            <span class="title">{{ ling('locale') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin_panel/translations') ? 'active' : '' }}">
                        <a href="{{ url('admin_panel/translations/en') }}" class="nav-link ">
                            <i class="fa fa-font"></i>
                            <span class="title">{{ ling('translations') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item {{ Request::is('admin_panel/add_exercise', 'admin_panel/exercises') ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-speedometer"></i>
                    <span class="title">{{ ling('tests').'/'.ling('levels') }}</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="javascript:;" target="_blank" class="nav-link">
                            <i class="fa fa-futbol-o"></i> {{ ling('exercises') }}
                            <span class="arrow nav-toggle"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="{{ url('admin_panel/add_exercise') }}" class="nav-link">
                                    <i class="fa fa-plus"></i> {{ ling('add_new_exercise') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin_panel/exercises') }}" class="nav-link">
                                    <i class="fa fa-list-ul"></i> {{ ling('exercise_list') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="?p=dashboard-2" target="_blank" class="nav-link">
                            <i class="icon-graph"></i> {{ ling('points').'/'.ling('levels') }}
                            <span class="arrow nav-toggle"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!-- /Super Admin Access Menu -->

            <!-- Admin Access Menu -->
            @if(Auth::user()->isAdmin())
            <li class="nav-item start {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ ling('dashboard') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin/organizations') ? 'active' : '' }}">
                <a href="{{ url('admin/organizations') }}" class="nav-link nav-toggle">
                    <i class="fa fa-building-o"></i>
                    <span class="title">{{ ling('organizations') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin/add_manager', 'admin/managers_list') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-black-tie"></i>
                    <span class="title">{{ ling('managers') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin/add_manager') ? 'active' : '' }}">
                        <a href="{{ url('admin/add_manager') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_new_manager') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin/managers_list') ? 'active' : '' }}">
                        <a href="{{ url('admin/managers_list') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('managers_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('admin/teams') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ ling('teams') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin/add_team') ? 'active' : '' }}">
                        <a href="{{ url('admin/add_team') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_team') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ url('admin/teams') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('teams_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <!--  -->
            <li class="nav-item start {{ Request::is('admin/players', 'admin/add_player') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ ling('players') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('admin/add_player') ? 'active' : '' }}">
                        <a href="{{ url('admin/add_player') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_new_player') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('admin/players') ? 'active' : '' }}">
                        <a href="{{ url('admin/players') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('players_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            @endif
            <!-- /Admin Access Menu -->

            <!-- Manager Access Menu -->
            @if(Auth::user()->isManager())
            <li class="nav-item start {{ Request::is('manager/dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ ling('dashboard') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item start {{ Request::is('manager/organization') ? 'active' : '' }}">
                <a href="{{ url('manager/organization') }}" class="nav-link nav-toggle">
                    <i class="fa fa-building-o"></i>
                    <span class="title">{{ ling('organizations') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('manager/teams', 'manager/add_team', 'manager/edit_team') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ ling('teams') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('manager/add_team') ? 'active' : '' }}">
                        <a href="{{ url('manager/add_team') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_team') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ url('manager/teams') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('teams_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            <li class="nav-item start {{ Request::is('manager/players', 'manager/add_player') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ ling('players') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ Request::is('manager/add_player') ? 'active' : '' }}">
                        <a href="{{ url('manager/add_player') }}" class="nav-link ">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ ling('add_new_player') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ Request::is('manager/players') ? 'active' : '' }}">
                        <a href="{{ url('manager/players') }}" class="nav-link ">
                            <i class="fa fa-list-ul"></i>
                            <span class="title">{{ ling('players_list') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--  -->
            @endif
            <!-- /Manager Access Menu -->

            <!-- Player Access Menu -->
            @if(Auth::user()->isPlayer())
            <li class="nav-item start {{ Request::is('player/dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ ling('dashboard') }}</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            <!-- /Player Access Menu -->

        </ul>
        
        <!-- END SIDEBAR MENU -->
    </div>
</div>