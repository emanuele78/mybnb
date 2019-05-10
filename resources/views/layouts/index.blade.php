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
    @include('components.footer')
@endsection
@section('body_injection')
    @if (session('flash_message'))
        <div class="flash_message">
            <span>{{session('flash_message')}}</span>
        </div>
    @endif
@endsection
@push('scripts')
    @unless($hasValidToken)
        <script src="{{asset('js/token_processor.js')}}"></script>
    @endunless
    <script src="{{asset('js/index.js')}}"></script>
@endpush
