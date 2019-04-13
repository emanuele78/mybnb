@extends('layouts.base')

@section('content')
    @push('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    @unless($hasValidToken)
        @include('components.token_section')
    @endunless
    @include('components.hero')
    {{--todo absolute position message--}}
    @if (session('flash_message'))
        <div>
            {{ session('flash_message') }}
        </div>
    @endif
    @include('components.promoteds_list')
    @include('components.cards_list')
    @include('components.footer')
    @push('scripts')
        <script id="cities_list_template" type="text/x-handlebars-template">
            @{{#each this}}
            <option class="city_item" data-id="@{{code}}" value="@{{name}}"></option>
            @{{/each}}
        </script>
        @unless($hasValidToken)
            <script src="{{asset('js/token_processor.js')}}"></script>
        @endunless
        <script src="{{asset('js/index.js')}}"></script>
    @endpush
@endsection