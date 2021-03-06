@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    @include('components.threads_index_content')
@endsection
@push('scripts')
    <script src="{{asset('js/threads_index.js')}}"></script>
@endpush