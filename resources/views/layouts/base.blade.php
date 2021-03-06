<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @stack('meta')
        <link href="{{asset('font/css/all.css')}}" rel="stylesheet">
        @stack('styles')
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/plain.css')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('site.webmanifest')}}">
        <script type="text/javascript">
            var _iub = _iub || [];
            _iub.csConfiguration = {"priorConsent":false,"lang":"it","siteId":1583375,"consentOnScroll":false,"cookiePolicyId":12084778, "banner":{ "position":"top" }};
        </script><script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>
        <title>MyBnB | Emanuele Mazzante Portfolio</title>
    </head>
    <body>
        @yield('body_injection')
        @include('components.navbar')
        <div class="base_container">
            @yield('content')
        </div>
        <script src="{{asset('js/manifest.js')}}"></script>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/navbar.js')}}"></script>
        @stack('scripts')
    </body>
</html>