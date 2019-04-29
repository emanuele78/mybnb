@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.booking_index_content')
@endsection
@push('scripts')
    <script src="{{asset('js/booking_index.js')}}"></script>
@endpush