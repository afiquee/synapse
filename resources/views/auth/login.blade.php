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
</head>

<body>

    <div class="containers">

        <div class="cards">
            <div class="cards-header">
                <h4 class="align-left">{{ __('User Login') }}</h4>
            </div>
            <div class="cards-content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="rows">
                        <label class="input-label" for="planet">Email</label>
                        <input name="email" id="email" class="input-text @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" type="text" placeholder="Email" required />
                        @error('email')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="rows">
                        <label class="input-label">Password</label>
                        <input name="password" id="password" class="input-text @error('email') is-invalid @enderror"
                            type="password" placeholder="Password" required />
                        @error('email')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="rows">
                        <button type="submit" class="btn btn-green"> {{ __('Login') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>

</html>