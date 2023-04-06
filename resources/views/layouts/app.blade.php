<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
   @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .mr-1 {margin-right: 1em;}
    </style>

    @yield('header')

</head>
<body>
<div id="app">
    <navview :open="true" :channels="{{$channels}}"></navview>

    <main class="py-4">
        @yield('content')
    </main>
    <flash message="{{ session('flash') }}"></flash>

</div>
</body>
</html>
<script>
    window.App = {!! json_encode([
        'csrfToken' => csrf_token(),
        'signIn' => Auth::check(),
        'user' => Auth::user()
    ]) !!};
</script>
