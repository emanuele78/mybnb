@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.apartment_payment_content')
    <div class="container my-3">
        @component('components.payment_form')
        @endcomponent
    </div>
@endsection
@push('scripts')
    <script src="https://js.braintreegateway.com/web/3.44.2/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.44.2/js/hosted-fields.min.js"></script>
    <script src="{{asset('js/payment.js')}}"></script>
@endpush
