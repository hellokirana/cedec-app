<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <title>CEdEC Jakarta Global University</title>

    <!-- Stylesheets -->
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">
    <!-- Favicon -->
     
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


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
                                    <a href="<?php echo e(url('/')); ?>">
                                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="logo" width="250">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="header-center-column" <?php if(auth()->guard()->guest()): ?> style="min-height: 90px;" <?php endif; ?>>
                            <div class="nav-outer">
                                <div class="mobile-nav-toggler">
                                    <img src="<?php echo e(asset('assets/images/icons/icon-bar.png')); ?>" alt="icon">
                                </div>
                                <nav class="main-menu navbar-expand-md navbar-light">
                                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                        <ul class="navigation">
                                            <?php if(auth()->guard()->check()): ?>
                                            <?php if(Auth::user()->email_verified_at): ?>
                                            <li>
                                                <a href="<?php echo e(url('/')); ?>">Home</a>
                                            </li>
                                            <li class="dropdown">
                                                <a>Workshops <i class="fa-solid fa-chevron-down ms-1"></i></a>
                                                <ul>
                                                    <li><a href="<?php echo e(url('/workshop')); ?>">All Workshops</a></li>
                                                    <li><a href="<?php echo e(url('/my-workshop')); ?>">My Workshops</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(url('/result')); ?>">Result & Certificate</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(url('/contact')); ?>">Contact</a>
                                            </li>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>

            <!-- Header Right -->
            <div class="header-right-column d-flex align-items-center">
                <div class="header-right-btn-area">
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(url('login')); ?>" class="btn-1">Login</a>
                        <a href="<?php echo e(url('register')); ?>" class="btn-1">Register</a>
                    <?php else: ?>
                        <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')): ?>
                            <a href="<?php echo e(url('home')); ?>" class="btn-1">Admin</a>
                        <?php else: ?>
                            <div class="dropdown d-flex align-items-center gap-2">
                                <img 
                                    src="<?php echo e(Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/images/icons/default-avatar.png')); ?>" 
                                    alt="Avatar"
                                    class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;"
                                >
                                <a class="dropdown-toggle text-dark fw-semibold" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo e(Auth::user()->name); ?>

                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('student.profile')); ?>">Profile</a></li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
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
                                    <div class="logo"><a href="<?php echo e(url('/')); ?>"><img
                                                src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="logo" width='250'></a></div>
                                </div>
                            </div>

                            <div class="nav-outer gap-5 d-flex align-items-center">
                                <div class="mobile-nav-toggler"><img
                                        src="<?php echo e(asset('assets/images/icons/icon-bar.png')); ?>" alt="icon"></div>
                                <nav class="main-menu navbar-expand-md navbar-light"></nav>
                            </div>

                            <div class="header-right-column d-flex align-items-center">
                <div class="header-right-btn-area">
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(url('login')); ?>" class="btn-1">Login</a>
                        <a href="<?php echo e(url('register')); ?>" class="btn-1">Register</a>
                    <?php else: ?>
                        <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')): ?>
                            <a href="<?php echo e(url('home')); ?>" class="btn-1">Admin</a>
                        <?php else: ?>
                            <div class="dropdown d-flex align-items-center gap-2">
                    <img 
                                    src="<?php echo e(Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/images/icons/default-avatar.png')); ?>" 
                        alt="Avatar"
                        class="rounded-circle"
                        style="width: 32px; height: 32px; object-fit: cover;"
                    >
                    <a class="dropdown-toggle text-dark fw-semibold" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo e(Auth::user()->name); ?>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('student.profile')); ?>">Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </div>
                        <?php endif; ?>
                    <?php endif; ?>
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
                        <a href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="logo">
                        </a>
                    </div>

                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>

                    <!-- Mobile Menu Login/Register -->
                    <div class="mobile-auth-buttons mt-4 text-center">
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(url('login')); ?>" class="d-block mb-2 text-dark">Login</a>
                            <a href="<?php echo e(url('register')); ?>" class="d-block text-dark">Register</a>
                        <?php else: ?>
                            <?php if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')): ?>
                                <a href="<?php echo e(url('home')); ?>" class="d-block text-dark">Member Area</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/profil')); ?>" class="d-block text-dark mb-2">Profil (<?php echo e(Auth::user()->name); ?>)</a>
                                <a href="<?php echo e(route('logout')); ?>"
                                class="d-block text-dark"
                                onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                                    Logout
                                </a>
                                <form id="mobile-logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </header>
        <!-- header -->


        <?php echo $__env->yieldContent('content'); ?>

        <!-- footer -->
        <?php if(auth()->guard()->check()): ?>
            <footer id="footer" class="main-footer footer-one">
            <div class="footer-copyright">
                <div class="container">
                    <div class="footer-copyright-content text-center">
                        <p class="small text-muted mb-0">&copy; 2025 | All rights reserved</p>
                    </div>
                </div>
            </div>
        </footer>
        <?php endif; ?>
        
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



    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.nice-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/appear.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/wow.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/TweenMax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/odometer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/swiper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/parallax-scroll.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jarallax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.paroller.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.magnific-popup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/isotope.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/flatpickr-min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/socialSharing.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH D:\laragon\www\cedec-app\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>