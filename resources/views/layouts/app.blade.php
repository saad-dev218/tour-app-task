<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        #app {
            flex: 1;
        }

        .sidebar-link {
            color: #fff;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
            /* Bootstrap primary color */

            font-weight: 600;
        }

        .sidebar-heading {
            color: #adb5bd;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 15px 20px 5px;
        }

        .offcanvas-body {
            padding: 0;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        .offcanvas-title {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @auth
                    <button class="btn btn-dark me-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                        ☰
                    </button>
                @endauth

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto">
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @guest
            <main class="py-4">
                @yield('content')
            </main>
        @else
            <!-- Sidebar Offcanvas -->
            <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar"
                aria-labelledby="offcanvasSidebarLabel">
                <div class="offcanvas-header border-bottom border-secondary">
                    <h5 class="offcanvas-title" id="offcanvasSidebarLabel">{{ config('app.name', 'Laravel') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Dashboard</a>

                    <a href="#" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}"> Users</a>

                    <a href="#" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                        Settings</a>

                    <div class="sidebar-heading">Account</div>
                    <a href="#" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        Profile</a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="container-fluid mt-4">
                @yield('content')
            </div>
        @endguest
    </div>

    <footer class="footer">
        <div class="container">
            &copy; {{ now()->year }} {{ config('app.name', 'Laravel') }}. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
