<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <title>CEdEC Jakarta Global University</title>

    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- Favicon -->
     
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

    <div class="page-wrapper">
        <!-- header -->
        <header class="main-header header-style-one">

            <!-- Header Lower -->
            <div class="header-lower">
                <div class="container">
                    <div class="inner-container d-flex align-items-center justify-content-between">
                        
                        <!-- Logo -->
                        <div class="header-left-column">
                            <div class="logo-box">
                                <div class="logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="250">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="header-center-column" @guest style="min-height: 90px;" @endguest>
                            <div class="nav-outer">
                                <div class="mobile-nav-toggler">
                                    <img src="{{ asset('assets/images/icons/icon-bar.png') }}" alt="icon">
                                </div>
                                <nav class="main-menu navbar-expand-md navbar-light">
                                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                        <ul class="navigation">
                                            @auth
                                            @if(Auth::user()->email_verified_at)
                                            <li>
                                                <a href="{{ url('/') }}">Home</a>
                                            </li>
                                            <li class="dropdown">
                                                <a>Workshops <i class="fa-solid fa-chevron-down ms-1"></i></a>
                                                <ul>
                                                    <li><a href="{{ url('/workshop') }}">All Workshops</a></li>
                                                    <li><a href="{{ url('/my-workshop') }}">My Workshops</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="{{ url('/result') }}">Result & Certificate</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/contact') }}">Contact</a>
                                            </li>
                                            @endif
                                            @endauth
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>

            <!-- Header Right -->
            <div class="header-right-column d-flex align-items-center">
                <div class="header-right-btn-area">
                    @guest
                        <a href="{{ url('login') }}" class="btn-1">Login</a>
                        <a href="{{ url('register') }}" class="btn-1">Register</a>
                    @else
                        @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                            <a href="{{ url('home') }}" class="btn-1">Admin</a>
                        @else
                            <div class="dropdown d-flex align-items-center gap-2">
                                <img 
                                    src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/images/icons/default-avatar.png') }}" 
                                    alt="Avatar"
                                    class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;"
                                >
                                <a class="dropdown-toggle text-dark fw-semibold" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Lower -->



            <!-- sticky header -->
            <div class="sticky-header">
                <div class="header-upper">
                    <div class="container">
                        <div class="inner-container d-flex align-items-center justify-content-between">
                            <div class="left-column d-flex align-items-center">
                                <div class="logo-box">
                                    <div class="logo"><a href="{{ url('/') }}"><img
                                                src="{{ asset('assets/images/logo.png') }}" alt="logo" width='250'></a></div>
                                </div>
                            </div>

                            <div class="nav-outer gap-5 d-flex align-items-center">
                                <div class="mobile-nav-toggler"><img
                                        src="{{ asset('assets/images/icons/icon-bar.png') }}" alt="icon"></div>
                                <nav class="main-menu navbar-expand-md navbar-light"></nav>
                            </div>

                            <div class="header-right-column d-flex align-items-center">
                <div class="header-right-btn-area">
                    @guest
                        <a href="{{ url('login') }}" class="btn-1">Login</a>
                        <a href="{{ url('register') }}" class="btn-1">Register</a>
                    @else
                        @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                            <a href="{{ url('home') }}" class="btn-1">Admin</a>
                        @else
                            <div class="dropdown d-flex align-items-center gap-2">
                    <img 
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/icons/default-avatar.png') }}" 
                        alt="Avatar"
                        class="rounded-circle"
                        style="width: 32px; height: 32px; object-fit: cover;"
                    >
                    <a class="dropdown-toggle text-dark fw-semibold" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                        @endif
                    @endguest
                </div>
            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sticky header -->

            <!-- mobile menu -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="fal fa-times"></span></div>

                <nav class="menu-box">
                    <div class="nav-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                        </a>
                    </div>

                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>

                    <!-- Mobile Menu Login/Register -->
                    <div class="mobile-auth-buttons mt-4 text-center">
                        @guest
                            <a href="{{ url('login') }}" class="d-block mb-2 text-dark">Login</a>
                            <a href="{{ url('register') }}" class="d-block text-dark">Register</a>
                        @else
                            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                                <a href="{{ url('home') }}" class="d-block text-dark">Member Area</a>
                            @else
                                <a href="{{ url('/profil') }}" class="d-block text-dark mb-2">Profil ({{ Auth::user()->name }})</a>
                                <a href="{{ route('logout') }}"
                                class="d-block text-dark"
                                onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                                    Logout
                                </a>
                                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                        @endguest
                    </div>
                </nav>
            </div>
        </header>
        <!-- header -->


        @yield('content')

        <!-- footer -->
        @auth
            <footer id="footer" class="main-footer footer-one">
            <div class="footer-copyright">
                <div class="container">
                    <div class="footer-copyright-content text-center">
                        <p class="small text-muted mb-0">&copy; 2025 | All rights reserved</p>
                    </div>
                </div>
            </div>
        </footer>
        @endauth
        
        <!-- footer -->


    </div>


    <!--Scroll to top-->
    <div class="scroll-to-top">
        <div>
            <div class="scroll-top-inner">
                <div class="scroll-bar">
                    <div class="bar-inner"></div>
                </div>
                <div class="scroll-bar-text">Go To Top</div>
            </div>
        </div>
    </div>
    <!-- Scroll to top end -->



    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/appear.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr-min.js') }}"></script>
    <script src="{{ asset('assets/js/socialSharing.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('scripts')

</body>

</html>
