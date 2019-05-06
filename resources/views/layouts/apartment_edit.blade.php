@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.apartment_edit_content')
    @include('components.footer')
@endsection
@push('scripts')
    <script src="{{asset('js/apartment_create.js')}}"></script>
@endpush