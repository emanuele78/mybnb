<div class="container my-3">
    <div class="row">
        <div class="wrapper col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Stai effettuando una prenotazione all'appartamento</h5>
                    <p class="card-text text-primary">{{$apartment->title}}</p>
                    <p class="card-text">
                        <small class="text-muted">Proprietario {{$apartment->user->nickname}}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="wrapper col-4">
            <div class="card full_height">
                <div class="card-body">
                    <h5 class="card-title">Dati dell'allggio</h5>
                    <ul>
                        <li>
                            <strong>Persone ospitabili:</strong> {{$apartment->people_count}}
                        </li>
                        <li>
                            <strong>Metri quadri:</strong> {{$apartment->square_meters}}
                        </li>
                        <li>
                            <strong>Numero stanze:</strong> {{$apartment->room_count}}
                        </li>
                        <li>
                            <strong>Numero bagni:</strong> {{$apartment->bathroom_count}}
                        </li>
                        <li>
                            <strong>Massima permanenza:</strong> {{$apartment->max_stay}} {{$apartment->max_stay==1?'giorno':'giorni'}}
                        </li>
                        <li>
                            <strong>Prezzo a notte:</strong> Euro
                            <span class="apartment_price{{$apartment->sale>0? ' in_sale':''}}">{{number_format($apartment->price_per_night,2,',','.')}}</span>
                        </li>
                        @if($apartment->sale>0)
                            <li>
                                <strong>Prezzo scontato:</strong> Euro
                                <span class="text-danger"><strong>{{number_format($apartment->price_per_night - $apartment->price_per_night * $apartment->sale / 100,2,',','.')}}</strong></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="wrapper col-4">
            <div class="card full_height">
                <div class="card-body">
                    <h5 class="card-title">Servizi disponibili</h5>
                    <ul>
                        @foreach($apartment->upgrades as $upgrade)
                            @if($upgrade->price_per_night==0)
                                <li>{{ucfirst($upgrade->service->name)}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="wrapper col-4">
            <div class="card full_height">
                <div class="card-body">
                    <h5 class="card-title">Servizi con supplemento</h5>
                    @foreach($apartment->upgrades as $upgrade)
                        @if($upgrade->price_per_night>0)
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ucfirst($upgrade->service->name)}}" aria-label="Euro amount (with dot and two decimal places)" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Euro</span>
                                    <span class="input-group-text">{{number_format($upgrade->price_per_night,2,',','.')}}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="wrapper col-6">
            <div class="card full_height">
                <div class="card-header text-center">
                    <h5 class="card-title">Disponibilità:
                        <span id="result" class="">da verificare</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control col flatpicker flatpickr-input text-center" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly">
                        <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-in</strong>
                    </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control col flatpicker flatpickr-input text-center" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly">
                        <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-out</strong>
                    </span>
                    </div>
                    <div class="form-group my-2">
                        <button id="check_availability" data-apartment="{{$apartment->slug}}" class="btn btn-primary col">Verifica</button>
                    </div>
                    <div id="loading_block" class="form-group my-3 text-center collapse">
                        <span id="result"><i class="fas fa-spinner fa-pulse loading_availability"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper col-6">
            <div class="card full_height">
                <div class="card-header text-center">
                    <h5>Costi</h5>
                </div>
                <div class="card-body">
                    <div class="my-2">
                        <span>Totale notti:</span>
                    </div>
                    <div class="my-2">
                        <span>Costo appartamento:</span>
                    </div>
                    <div class="my-2">
                        <span>Costo servizi:</span>
                    </div>
                </div>
                <div class="card-footer">
                    <h5>Totale Euro</h5>
                </div>
            </div>
        </div>
    </div>
</div>