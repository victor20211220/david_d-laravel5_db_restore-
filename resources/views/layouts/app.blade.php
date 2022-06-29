<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ URL::asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ URL::asset("bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ URL::asset("bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset("tagging/jquery.tagsinput.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset("bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="{{ URL::asset("bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>

    <script src="{{ URL::asset("bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ URL::asset("bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
</head>
<body class="skin-blue">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo"><b>SMS</b> PORTAL</a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Left Side Of Navbar -->
            @if (Auth::guest())
                <!-- Non logged in nav links -->
                @else
                        <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                    <!-- Optionally, you can add icons to the links -->
                    <li {{{Request::is('/') ? ' class="active"' : null}}}><a href="{{ url('/') }}"><span>Create Lead</span></a></li>
                    <li class="treeview active">
                        <a href="#"><span>Leads</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @role('admin')
                            <li><a href="{{ url('/messages') }}">Review Leads</a></li>
                            <li {{{Request::is('/') ? ' class="active"' : null}}}><a href="{{ url('/followup') }}"><span>Follow Up Leads</span></a></li>
                            <li><a href="{{ url('/archive') }}">Leads Archive</a></li>
                            <li><a href="{{ url('/freeleads') }}">Free Leads</a></li>
                            @endrole
                            @role('admin')
                            <li><a href="{{ url('/premessages') }}">Predefined Messages</a></li>
                            @endrole
                        </ul>
                    </li>
                    @role('admin')
                    <li class="treeview active">
                        <a href="{{ url('/bulk') }}"><span>Bulk Messaging</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('/bulk/history') }}">Message History</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/contractors') }}"><span>Contractors</span></a></li>
                    <li><a href="{{ url('/industries') }}"><span>Industries</span></a></li>
                    <li class="treeview active">
                        <a href="#"><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('/users') }}">Manage Users</a></li>
                            <li><a href="{{ url('users/register') }}">Register New User</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/settings') }}"><span>Settings</span></a></li>
                    <li><a href="{{ url('/export') }}"><span>Export</span></a></li>
                    <li><a href="{{ url('/stats') }}"><span>Stats</span></a> </li>
                    <li style="margin: 20px 0px 0px 12px; color: #FFF;"><p><strong>SMS Portal:</strong> {{$smsCreadits}} <small>left</small></p></li>
                    @endrole
                </ul><!-- /.sidebar-menu -->
            @endif
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_title')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->

            <!-- Your Page Content Here -->
            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.2.0
        </div>
        <!-- Default to the left -->
        <strong>Copyright © <?php echo date("Y");?> <a href="http://www.megaleads.co.za/" target="_blank">Mega Leads</a>.</strong> All rights reserved.
    </footer>

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ URL::asset("bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset("bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/site.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>