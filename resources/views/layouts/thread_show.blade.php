@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.thread_show_content')
@endsection
@push('scripts')
    <script src="{{asset('js/thread_show.js')}}"></script>
@endpush