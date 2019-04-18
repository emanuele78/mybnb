<div class="container my-3 booking_section">
    <form action="{{route('payment',['apartment'=>$apartment->slug])}}" method="POST">
        @csrf
        <input type="hidden" name="apartment_slug" value="{{$apartment->slug}}">
        <div class="row">
            <div class="wrapper col">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <img src="{{asset('img/apartments')}}/{{$apartment->images()->first()->name}}" class="card-img" alt="">
                        </div>
                        <div class="col-md-9">
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
            </div>
        </div>
        <div class="row my-3">
            <div class="wrapper col-3">
                <div class="card full_height">
                    <div class="card-body">
                        <h5 class="card-title">Dati dell'alloggio</h5>
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
                                <strong>Permanenza massima:</strong> {{$apartment->max_stay}} {{$apartment->max_stay==1?'giorno':'giorni'}}
                            </li>
                            <li>
                                <strong>Prezzo a notte:</strong> Euro
                                <span data-apartment_price="{{$apartment->price_per_night}}" class="apartment_price{{$apartment->sale>0? ' in_sale':''}}">{{number_format($apartment->price_per_night,2,',','.')}}</span>
                            </li>
                            @if($apartment->sale>0)
                                <li>
                                    <strong>Prezzo scontato:</strong> Euro
                                    <span data-apartment_sale_price="{{$apartment->calcCurrentPrice()}}" class="apartment_sale_price text-danger"><strong>{{number_format($apartment->calcCurrentPrice(),2,',','.')}}</strong></span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="wrapper col-3">
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
            <div class="wrapper col-6">
                <div class="card full_height">
                    <div class="card-body">
                        <h5 class="card-title">Aggiungi servizi</h5>
                        @foreach($apartment->upgrades as $upgrade)
                            @if($upgrade->price_per_night>0)
                                <div class="input-group my-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input name="upgrades[]" value="{{$upgrade->service->slug}}" type="checkbox" class="upgrade_service" data-service_name="{{$upgrade->service->slug}}" data-service_price="{{$upgrade->price_per_night}}" aria-label="Checkbox for following text input">
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
                        <h5 class="card-title">Il tuo soggiorno</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control col flatpicker flatpickr-input text-center" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly" value="{{old('check_in')}}">
                            <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-in</strong>
                    </span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control col flatpicker flatpickr-input text-center" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly" value="{{old('check_out')}}">
                            <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-out</strong>
                    </span>
                        </div>
                        <div id="availability_result" data-apartment="{{$apartment->slug}}">
                            <div class="collapse loading_block">
                                <i class="fas fa-spinner fa-pulse loading_availability"></i>
                            </div>
                            <span id="result"></span>
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
                            <span class="font-weight-bold">Totale notti: </span><span id="day_count" class="text-muted"></span>
                        </div>
                        <div class="my-2">
                            <span class="font-weight-bold">Costo appartamento: </span><span id="apartment_amount" class="text-muted"></span>
                        </div>
                        <div class="my-2">
                            <span class="font-weight-bold">Costo servizi: </span><span id="services_amount" class="text-muted"></span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h5>Totale Euro
                            <span id="final_amount"></span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="wrapper col">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title">Richieste speciali</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="body" rows="6" name="special_requests" placeholder="Scrivi il tuo messaggio">{{ old('special_requests') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="wrapper col">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" id="proceed_to_booking" class="btn btn-secondary text-white col">Procedi con la prenotazione</button>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
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
    </form>
</div>