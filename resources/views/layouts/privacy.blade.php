@extends('layouts.base')

@section('content')
    <div class="container">
        <a href="https://www.iubenda.com/privacy-policy/12084778" class="iubenda-white no-brand iubenda-embed iub-body-embed" title="Privacy Policy">Privacy Policy</a>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">(function (w, d) {
            var loader = function () {
                var s = d.createElement("script"),
                    tag = d.getElementsByTagName("script")[0];
                s.src = "https://cdn.iubenda.com/iubenda.js";
                tag.parentNode.insertBefore(s, tag);
            };
            if (w.addEventListener) {
                w.addEventListener("load", loader, false);
            } else if (w.attachEvent) {
                w.attachEvent("onload", loader);
            } else {
                w.onload = loader;
            }
        })(window, document);</script>
@endpush