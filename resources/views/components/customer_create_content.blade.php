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
                                <label for="first_name">Nome</label>
                                <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Nome" required>
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name">Cognome</label>
                                <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Cognome" required>
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="street_address">Indirizzo</label>
                                <input type="text" class="form-control{{ $errors->has('street_address') ? ' is-invalid' : '' }}" id="street_address" name="street_address" value="{{ old('street_address') }}" placeholder="Indirizzo" required>
                                @if ($errors->has('street_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('street_address') }}</strong>
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
                                <label for="postal_code">CAP</label>
                                <input type="text" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="CAP" required>
                                @if ($errors->has('postal_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
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
