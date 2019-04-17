<div class="container my-3">
    <div class="row">
        <div class="wrapper col-9">
            <div class="card full_height">
                <div class="row no-gutters">
                    <div class="col-4 pl-2">
                        <div class="">
                            <div class="apartment_map my-4">
                                <img id="tomtom_map" data-apartment="{{$apartment->slug}}" class="card-img" src="{{asset('img/map_placeholder.jpg')}}">
                                <i id="marker" class="fas fa-map-marker-alt collapse"></i>
                                <div class="loading_map">
                                    <i class="fas fa-spinner fa-pulse"></i>
                                </div>
                            </div>
                            <div class="">
                                {{--@if($address['response'])--}}
                                {{--<small>--}}
                                {{--{{$address['streetName']}} {{$address['postal_code']}}--}}
                                {{--<br>--}}
                                {{--{{$address['municipality']}} - {{$address['province']}}--}}
                                {{--</small>--}}
                                {{--@else--}}
                                <span id="apartment_address"></span>
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title">{{$apartment->title}}</h5>
                            <p class="card-text">
                                <small class="text-muted">Descrizione fornita dal proprietario, {{$apartment->user->nickname}}</small>
                            </p>
                            <p class="card-text">{{$apartment->description}}</p>
                            <p class="card-text">
                                <small class="text-muted">Ultimo aggiornamento il {{$apartment->updated_at}}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper col-3">
            <div class="card full_height">
                <div class="card-body">
                    <h5 class="card-title">Verifica disponibilità</h5>
                    <div class="form-group">
                        <input type="text" class="form-control col-sm my-2 mr-2 flatpicker flatpickr-input text-center" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly">
                        <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-in</strong>
                    </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control col-sm my-2 mr-2 flatpicker flatpickr-input text-center" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly">
                        <span class="invalid-feedback" role="alert">
                        <strong>Verifica la data del check-out</strong>
                    </span>
                    </div>
                    <div class="form-group my-2">
                        <button id="check_availability" data-apartment="{{$apartment->slug}}" class="btn btn-primary col">Verifica</button>
                    </div>
                    <div class="form-group my-3 text-center">
                        <div class="collapse loading_block">
                            <i class="fas fa-spinner fa-pulse loading_availability"></i>
                        </div>
                        <span id="result"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-3">
    <div class="row">
        <div class="wrapper col-4">
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
                    <ul>
                        @foreach($apartment->upgrades as $upgrade)
                            @if($upgrade->price_per_night>0)
                                <li>{{ucfirst($upgrade->service->name)}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @auth()
        <div class="row my-3">
            <div class="wrapper col">
                <div class="card">
                    <div class="card-body my-2 mb-2">
                        <a id="book_apartment" href="{{route('booking',['apartment'=>$apartment->slug])}}" class="btn btn-success col">Vai alla pagina di prenotazione</a>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->id != $apartment->user->id)
            <div class="row my-3">
                <div class="wrapper col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" id="message_apartment_slug" value="{{$apartment->slug}}">
                                    <input type="hidden" id="message_sender_nickname" value="{{auth()->user()->nickname}}">
                                    <input type="hidden" id="message_recipient_nickname" value="{{$apartment->user->nickname}}">
                                    <div class="form-group">
                                        <label for="body">Invia un messaggio al proprietario, {{$apartment->user->nickname}}</label>
                                        <textarea class="form-control" id="body" rows="6" name="body" required placeholder="Scrivi il tuo messaggio"></textarea>
                                        <span class="invalid-feedback" role="alert">
                                        <strong>Il messaggio deve essere compreso tra 10 e 4000 caratteri</strong>
                                    </span>
                                    </div>
                                    <button id="submit_message" class="btn btn-primary pl-5 pr-5">Invia</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div id="message_wrapper" class="alert col">
                    <span id="message_response"></span>
                </div>
            </div>
        @endif
    @endauth
    @guest()
        <div class="row my-3">
            <div class="wrapper col">
                <div class="card">
                    <div class="card-body my-2 mb-2 text-center">
                        Per prenotare o inviare messaggi al proprietario devi fare il
                        <a href="{{route('login')}}" class="text-decoration-none"><strong>login</strong></a> o
                        <a href="{{route('register')}}" class="text-decoration-none"><strong>registrati</strong></a>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</div>
