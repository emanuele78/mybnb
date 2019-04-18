@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @include('components.booking_content')
    {{--@include('components.payment_form')--}}
@endsection
@push('scripts')
    <script src="{{asset('js/booking.js')}}"></script>
@endpush
