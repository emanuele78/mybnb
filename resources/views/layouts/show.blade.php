@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @include('components.carousel')
    @include('components.apartment_description')
    @include('components.footer')
@endsection
@push('scripts')
    <script src="{{asset('js/show_availability.js')}}"></script>
    <script src="{{asset('js/show_apartment.js')}}"></script>
@endpush
