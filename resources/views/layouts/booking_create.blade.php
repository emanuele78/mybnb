@extends('layouts.base')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="container">
        I'm the future page for booking
    </div>
@endsection