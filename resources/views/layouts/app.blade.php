<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">





    

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    



</head>

<body>
    <div class="page">
        <nav class="sideBar">
            <ul class="nav-list">
                <li class="nav-item">
                    <a>{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user') }}">{{ __('User') }}</a>
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
                    Synapse
                </div>
            </div>
            <div class="container">
                @yield('content')
                
            </div>
        </div>
</body>

</html>

@yield('scripts')