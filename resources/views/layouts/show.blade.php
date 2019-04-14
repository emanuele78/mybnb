@extends('layouts.base')

@section('content')
    @push('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    @include('components.carousel')
    @include('components.footer')
@endsection