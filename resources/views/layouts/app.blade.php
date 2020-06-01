<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Synapsis') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/d45262bf36.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="page">
        <nav class="sidebar" id="sidebar">
            <div class="flex-close">
                <span class="sidebar-close sidebar-menu"  onclick="toggleSidebar()"><i class="fas fa-times sidebar-menu"></i></span>
            </div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a>{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="{{ Route::currentRouteNamed('user') ? 'nav-active' : '' }}" href="{{ route('user') }}">{{ __('User') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('addOrder') }}">{{ __('Order') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
            <div>
            </div>

        </nav>
        <div class="content">
            <div class="header">
                <div class="headerContent">
                    <span onclick="toggleSidebar()" class="sidebar-toggle"><i
                            class="fas fa-bars sidebar-menu"></i></span>
                </div>
            </div>
            <div class="container">
                @yield('content')

            </div>
        </div>
</body>

</html>

<script>
function toggleSidebar() {

    $('#sidebar').toggleClass('sidebar-active');
    console.log($('#sidebar').hasClass('sidebar-active'));

}
</script>

@yield('scripts')