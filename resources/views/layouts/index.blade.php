@extends('layouts.base')

@section('content')
    @if(!$hasValidToken)
        @push('meta')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endpush
        @include('components.token_section')
        @push('scripts')
            @if(app()->environment('local'))
                <script>const TOKEN_ENDPOINT = '{{config('project.token_endpoint_development')}}'</script>
            @else
                <script>const TOKEN_ENDPOINT = '{{config('project.token_endpoint_development')}}'</script>
            @endif
            <script src="{{asset('js/token_processor.js')}}"></script>
        @endpush
    @endif
@endsection