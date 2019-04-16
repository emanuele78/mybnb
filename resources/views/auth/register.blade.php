@extends('layouts.base')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="wrapper my-4 offset-3 col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Registrati</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('do_registration')}}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Indirizo email</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Email" required autofocus>
                                <small id="emailHelp" class="form-text text-muted">Inserisci un qualsiasi indirizzo, anche finto. Non saranno inviate comunicazioni ed è valido solo ai fini della presente demo</small>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nickname">Nickname</label>
                                <input type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" id="nickname" name="nickname" value="{{ old('nickname') }}" placeholder="Nickname" required>
                                @if ($errors->has('nickname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Data di nascita</label>
                                <input type="text" class="form-control flatpicker flatpickr-input text-center{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="date_of_birth" name="date_of_birth" placeholder="dd-mm-aaaa" value="{{ old('date_of_birth') }}">
                                @if ($errors->has('date_of_birth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary col">Registrati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/user_registration.js')}}"></script>
@endpush