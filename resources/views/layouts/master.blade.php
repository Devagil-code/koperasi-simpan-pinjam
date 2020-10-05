
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Sistem Informasi Koperasi Karyawan Prasetiyamulya</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App css -->

        @yield('style')
        <!-- Toastr css -->
        <link href="{{ asset('plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    </head>
    <body>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="{{ route('home') }}" class="logo">
                        <span>
                            <img src="{{ asset('images/koperasi-indonesia.png') }}" alt="" height="60">
                        </span>
                        <i>
                            <img src="{{ asset('images/koperasi-indonesia.png') }}" alt="" height="50">
                        </i>
                    </a>
                </div>
                <nav class="navbar-custom">
                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('images/users/avatar-1.jpg') }}" alt="user" class="rounded-circle"> <span class="ml-1">{{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h6 class="text-overflow m-0">Selamat Datang !</h6>
                                </div>
                                <a href="{{ route('user.user-profile', Auth::user()->id )}}" class="dropdown-item notify-item">
                                    <i class="fi-head"></i> <span>My Account</span>
                                </a>
                                <a href="{{ url('/logout') }}" class="dropdown-item notify-item"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fi-power"></i> <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>
                    </ul>
                </nav>

            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.menu')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    {{ Options::show('footer') }}
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        <!-- jQuery  -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('js/waves.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>


        <!-- App js -->
        <script src="{{ asset('js/jquery.core.js') }}"></script>
        <script src="{{ asset('js/jquery.app.js') }}"></script>
        <script src="{{ asset('plugins/jquery-toastr/jquery.toast.min.js') }}" type="text/javascript"></script>
        @yield('script')
        @if ($message = Session::get('error'))
            <script>
                $.toast({
                    heading: 'Error !',
                    text: '{!! $message !!}',
                    position: 'top-right',
                    loaderBg: '#bf441d',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 1
                });
            </script>
        @endif
    </body>
</html>
