@section('content')
    <div class="container">
        <div class="row">
            <div class="wrapper my-4 offset-3 col-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Registrati come cliente</h3>
                        <h6 class="card-subtitle mb-2 my-1 text-muted">Con questa registrazione potrai prenotare e pubblicare appartamenti</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('save_customer')}}">
                            @csrf
                            <div class="form-group">
                                <label for="firstName">Nome</label>
                                <input type="text" class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" id="firstName" name="firstName" value="{{ old('firstName') }}" placeholder="Nome" required>
                                @if ($errors->has('firstName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lastName">Cognome</label>
                                <input type="text" class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" id="lastName" name="lastName" value="{{ old('lastName') }}" placeholder="Cognome" required>
                                @if ($errors->has('lastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="streetAddress">Indirizzo</label>
                                <input type="text" class="form-control{{ $errors->has('streetAddress') ? ' is-invalid' : '' }}" id="streetAddress" name="streetAddress" value="{{ old('streetAddress') }}" placeholder="Indirizzo" required>
                                @if ($errors->has('streetAddress'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('streetAddress') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="locality">Località</label>
                                <input type="text" class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}" id="locality" name="locality" value="{{ old('locality') }}" placeholder="Località" required>
                                @if ($errors->has('locality'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('locality') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="postalCode">CAP</label>
                                <input type="text" class="form-control{{ $errors->has('postalCode') ? ' is-invalid' : '' }}" id="postalCode" name="postalCode" value="{{ old('postalCode') }}" placeholder="CAP" required>
                                @if ($errors->has('postalCode'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('postalCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary col">Registrati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())streetAddress
            <div class="row">
                <div class="wrapper col">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
