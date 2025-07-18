<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin CEdEC') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- Favicon -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/remixicon/remixicon.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="250">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto text-capitalize">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('home') }}">dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('data/workshop') }}">Workshop</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('payment.confirmation') }}">Payment Confirmation</a>
                            </li>

                            <li class="nav-item dropdown">
                                    <a id="layanan_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        User Management
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="user_menu">
                                        <a class="dropdown-item" href="{{ url('data/student') }}">student</a>
                                        <a class="dropdown-item" href="{{ url('data/admin') }}">admin</a>
                                    </div>
                                </li>

                                </li>
                                <li class="nav-item dropdown">
                                    <a id="layanan_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Result
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="user_menu">
                                        <a class="dropdown-item" href="{{ route('score.index') }}">Score</a>
                                        <a class="dropdown-item" href="{{ url('data/certificate') }}">Certificate</a
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="konten_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Settings
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="konten_menu">
                                        <a class="dropdown-item" href="{{ url('data/program') }}">Program</a>
                                        <a class="dropdown-item" href="{{ url('data/bank') }}">Bank</a>
                                    </div>
                                </li>
                            @endhasanyrole
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('profil') }}">Profil</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#select_data').select2({
        //         placeholder: "Select an option",
        //         allowClear: true
        //     });
        // });
        $(document).on('click', '.update_data', function() {
            let element = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light',
                    cancelButton: 'btn btn-danger waves-effect'
                },
                showClass: {
                    popup: 'animate__animated animate__bounceIn'
                },
                buttonsStyling: true,
                confirmButtonText: "Yes",
                showCancelButton: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = element.data('url');
                };
            })
        });
        $(document).on('click', '.delete-post', function(e) {
            e.preventDefault();

            var url = $(this).data('url_href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.success,
                                'success'
                            ).then(() => {
                                location
                                    .reload(); // Reload the page to see the updated list
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the post.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

    @if (Session::has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Berhasil",
                text: "{{ Session::get('success') }}",
                timer: 3000
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Peringatan",
                text: "{{ Session::get('error') }}",
                timer: 3000
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>
