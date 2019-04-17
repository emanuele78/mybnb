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
    <!-- Load the required client component. -->
    {{--<script src="https://js.braintreegateway.com/web/3.44.2/js/client.min.js"></script>--}}
    <!-- Load Hosted Fields component. -->
    {{--<script src="https://js.braintreegateway.com/web/3.44.2/js/hosted-fields.min.js"></script>--}}
    {{--<script src="{{asset('js/payment.js')}}"></script>--}}
@endpush
