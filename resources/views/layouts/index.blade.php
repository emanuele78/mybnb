@extends('layouts.base')

@section('content')
    @push('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    @if($showTokenBanner)
        @include('components.token_section')
    @endif
    @include('components.hero')
    @push('scripts')
        <script id="cities_list_template" type="text/x-handlebars-template">
            @{{#each this}}
            <option class="city_item" data-id="@{{code}}" value="@{{name}}"></option>
            @{{/each}}
        </script>
        @if($showTokenBanner)
            <script src="{{asset('js/token_processor.js')}}"></script>
        @endif
        <script src="{{asset('js/index.js')}}"></script>
    @endpush
@endsection