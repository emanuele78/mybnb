@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @include('components.customer_create_content')
@endsection
@push('scripts')
    <script src="{{asset('js/customer_registration.js')}}"></script>
@endpush
