<!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="index.html" class="logo"><span>Football<span>hub</span></span></a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li>
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                     <input type="text" placeholder="Search..." class="form-control">
                                     <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <li>
                                <!-- Notification -->
                                <div class="notification-box">
                                    <ul class="list-inline m-b-0">
                                        <li>
                                            <a href="javascript:void(0);" class="right-bar-toggle">
                                                <i class="zmdi zmdi-notifications-none"></i>
                                            </a>
                                            <div class="noti-dot">
                                                <span class="dot"></span>
                                                <span class="pulse"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Notification bar -->
                            </li>

                            <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            
                                        <i class="ti-power-off m-r-5"></i>Logout</a></li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>

                </div>
            </div>

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                            </li>
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-invert-colors"></i> <span> Users </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="{{ route('suspendedAdmins') }}">Suspended Admins</a></li>
                                            <li><a href="{{ route('unsuspendedAdmins') }}">UnSuspended Admins</a></li>
                                    <li><a href="{{ route('createAdminView') }}">Create Admin</a></li>
                                    <li><a href="{{ route('unsuspendedUsers') }}">Unsuspended Users</a></li>
                                    <li><a href="{{ route('suspendedUsers') }}">Suspended Users</a></li>
                                    <li><a href="{{ route('createUser') }}">Create User</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-collection-text"></i><span> Feeds </span> </a>
                                <ul class="submenu">
                                    <li><a href="{{ route('indexUnFootballHubFeeds') }}">Football Hub Feeds</a></li>
                                    <li><a href="{{ route('indexGeneralFeeds') }}">InActive General Feeds</a></li>
                                    <li><a href="{{ route('indexUnGeneralFeeds') }}">Active General Feeds</a></li>
                                    
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-collection-text"></i><span> Teams </span> </a>
                                <ul class="submenu">
                                    <li>
                                        <a href="{{route('allActiveTeamsView')}}">Active Teams</a>
                                    </li>
                                    <li>
                                        <a href="{{route('allInActiveTeamsView')}}">InActive Teams</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('allMatchesView')}}"><i class="zmdi zmdi-collection-text"></i>Friendly Matches</a>
                            </li>
                            <li>
                                <a href="{{route('league')}}"><i class="zmdi zmdi-invert-colors"></i>League</a>
                            </li>
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-view-list"></i> <span> Reports </span> </a>
                                <ul  class="submenu">
                                    <li><a href="{{ route('indexReportsView') }}">Reports</a></li>
                                    <li><a href="{{ route('createReportView') }}">Create Report</a></li>
                                </ul>
                            </li>

                            <li><a href="{{ route('showTermsAndConditions') }}">Terms and Conditions</a></li>

                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->

