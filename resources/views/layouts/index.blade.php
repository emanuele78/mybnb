@extends('layouts.base')

@section('content')
    @if(!$hasValidToken)
        @push('meta')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endpush
        @include('components.token_section')
        @push('scripts')
            <script src="{{asset('js/token_processor.js')}}"></script>
        @endpush
    @endif
@endsection