@extends('layouts.base')

@section('content')
    @if(!$hasValidToken)
        @push('meta')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endpush
        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @endpush
        @include('components.token_section')
        @include('components.hero')
        @push('scripts')
            <script id="cities_list_template" type="text/x-handlebars-template">
                @{{#each this}}
                <option class="city_item" data-id="@{{code}}" value="@{{name}}"></option>
                @{{/each}}
            </script>
            <script src="{{asset('js/token_processor.js')}}"></script>
            <script src="{{asset('js/index.js')}}"></script>
        @endpush
    @endif
@endsection