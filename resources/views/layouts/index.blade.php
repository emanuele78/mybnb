@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @unless($hasValidToken)
        @include('components.index_token_content')
    @endunless
    @include('components.index_hero_content')
    {{--todo absolute position message--}}
    @if (session('flash_message'))
        <div>
            {{ session('flash_message') }}
        </div>
    @endif
    @include('components.index_promotions_content')
    @include('components.index_cities_content')
    @include('components.footer')
@endsection
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
