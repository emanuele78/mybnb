@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.apartment_index_content')
@endsection
@push('scripts')
    <script src="{{asset('js/apartment_index.js')}}"></script>
@endpush