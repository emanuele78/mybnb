<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @stack('meta')
        @stack('styles')
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/plain.css')}}">
        <script type="text/javascript">
            var _iub = _iub || [];
            _iub.csConfiguration = {"consentOnContinuedBrowsing":true,"lang":"it","siteId":1583375,"priorConsent":false,"cookiePolicyId":12084778, "banner":{ "position":"top" } };
        </script><script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async> </script>
        <title>MyBnB | Emanuele Mazzante Portfolio</title>
    </head>
    <body>
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