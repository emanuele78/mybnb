@extends('layouts.base')

@section('content')
    @push('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <form>
        <div class="form-group">
            <label for="email">Nickname</label>
            <input type="text" class="form-control" id="nickname" placeholder="Nickname">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email">
            <small id="emailHelp" class="form-text text-muted">Inserisci un qualsiasi indirizzo - anche finto. Non saranno inviate comunicazioni ed è valido solo ai fini della demo</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection