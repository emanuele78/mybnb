@extends('layouts.base')

@push('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    @unless($hasValidToken)
        @include('components.index_token_content')
    @endunless
    @include('components.index_content')
    {{--todo absolute position message--}}
    @if (session('flash_message'))
        <div>
            {{ session('flash_message') }}
        </div>
    @endif
    @include('components.footer')
@endsection
@push('scripts')
    @unless($hasValidToken)
        <script src="{{asset('js/token_processor.js')}}"></script>
    @endunless
    <script src="{{asset('js/index.js')}}"></script>
@endpush
