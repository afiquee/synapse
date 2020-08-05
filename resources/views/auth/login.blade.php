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
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">
                        <h4 class="align-left">{{ __('User Login') }}</h4>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('loginUser') }}">
                            @csrf
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="input-label" for="planet">Email</label>
                                        <input name="email" id="email"
                                            class="input-text @if ($errors->any()) is-invalid  @endif"
                                            value="{{ old('email') }}" type="text" placeholder="Email" required />
                                        @if ($errors->any())
                                        <label class="label-error"> {{ $errors->first() }} </label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="input-label">Password</label>
                                        <input name="password" id="password"
                                            class="input-text  @if ($errors->any()) is-invalid  @endif" type="password"
                                            placeholder="Password" required />
                                    </div>
                                </div>
                                <div class="full-input">
                                    <button type="submit" class="btn btn-green"> {{ __('Login') }}</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>