<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @stack('meta')
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/plain.css')}}">
        @stack('styles')
        <title>MyBnB | Emanuele Mazzante Portfolio</title>
    </head>
    <body>
        @include('components.navbar')
        <div class="container base_container">
            @yield('content')
        </div>
        @stack('scripts')
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>