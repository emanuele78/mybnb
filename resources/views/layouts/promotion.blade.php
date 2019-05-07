@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @include('components.promotion_content')
@endsection
@push('scripts')
    <script src="https://js.braintreegateway.com/web/3.44.2/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.44.2/js/hosted-fields.min.js"></script>
    <script src="{{asset('js/promotion.js')}}"></script>
@endpush