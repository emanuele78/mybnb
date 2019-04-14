@extends('layouts.base')
@section('content')
    @push('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <div class="container">
        <div class="card my-4">
            <div class="card-header text-center">
                <h3>Effettua il login</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('login')}}">
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
                        <label for="password">Password</label>
                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection