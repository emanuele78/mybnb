<div class="container new_apartment_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center">Inserisci nuovo appartamento</h3>
        </div>
    </div>
    <form action="{{route('save_apartment')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Titolo e descrizione</h5>
            </div>
            <div class="card-body">
                <div class="card-block">
                    <div class="form-group">
                        <label for="apartment_title" class="text-muted">Titolo</label>
                        <input id="apartment_title" name="title" type="text" class="form-control {{$errors->has('title')?'is-invalid':null}}" placeholder="Inserisci un titolo per l'appartamento" value="{{old('title')}}">
                        <div class="invalid-feedback">
                            Il titolo deve essere compreso tra 10 e 255 caratteri
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apartment_description" class="text-muted">Descrizione</label>
                        <textarea id="apartment_description" name="description" class="form-control {{$errors->has('description')?'is-invalid':null}}" rows="6" placeholder="Fornisci una descrizione per l'appartamento">{{old('description')}}</textarea>
                        <div class="invalid-feedback">
                            La descrizione deve essere compresa tra 20 e 4000 caratteri
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Località</h5>
            </div>
            <div class="row no-gutters">
                <div class="col-3">
                    <div class="apartment_map my-2 ml-2">
                        <img id="tomtom_map" class="card-img" src="{{asset('img/map_placeholder.jpg')}}">
                        <div id="marker" class="collapse">
                            <i id="marker" class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="mx-2 mt-2">
                        <div class="form-row">
                            <div class="col">
                                <input id="address" type="text" class="form-control" placeholder="cerca indirizzo">
                                <div class="invalid-feedback">
                                    Input di ricerca troppo corto
                                </div>
                            </div>
                            <div class="">
                                <button id="locality_search_button" class="btn btn-primary px-5">Cerca</button>
                            </div>
                        </div>
                    </div>
                    <div class="row address_search_results collapse">
                        <div class="col-12 mx-2 mt-1">
                            <span class="text-muted">Seleziona l'indirizzo tra i risultati trovati:</span>
                            <input type="hidden" class="address_input" name="address_lat" value="">
                            <input type="hidden" class="address_input" name="address_lng" value="">
                        </div>
                        <div class="col mx-2 mt-1 ">
                            <div class="address_search_results_content"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="waiting waiting_address collapse">
                <div class="loading_wrapper">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Dettagli appartamento</h5>
            </div>
            <div class="card-body">
                <div class="card-block">
                    <div class="form-group">
                        <label for="room-selection">Numero stanze</label>
                        <select name="room_count" class="custom-select {{$errors->has('room_count')?'is-invalid':null}}" id="room-selection">
                            <option {{old('room_count')==null?'selected':null}}>Scegli</option>
                            @for ($i = 1; $i <= $max_room_value; $i++)
                                <option {{old('room_count')==$i?'selected':null}} value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">
                            Selezionare il numero delle stanze
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="people-selection">Persone ospitabili</label>
                        <select name="people_count" class="custom-select {{$errors->has('people_count')?'is-invalid':null}}" id="people-selection">
                            <option {{old('people_count')==null?'selected':null}}>Scegli</option>
                            @for ($i = 1; $i <= $max_people_value; $i++)
                                <option {{old('people_count')==$i?'selected':null}} value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">
                            Selezionare il numero massimo di ospiti
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bathroom-selection">Numero bagni</label>
                        <select name="bathroom_count" class="custom-select {{$errors->has('bathroom_count')?'is-invalid':null}}" id="bathroom-selection">
                            <option {{old('bathroom_count')==null?'selected':null}}>Scegli</option>
                            @for ($i = 1; $i <= $max_bathroom_value; $i++)
                                <option {{old('bathroom_count')==$i?'selected':null}} name="bathroom_count" value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">
                            Selezionare il numero di bagni
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="square-meters">Metri quadri</label>
                        <input id="square-meters" name="square_meters" type="number" class="form-control {{$errors->has('square_meters')?'is-invalid':null}}" placeholder="es. 100" value="{{old('square_meters')}}">
                        <div class="invalid-feedback">
                            Inserire i metri quadri dell'appartamento
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max-stay">Massima durata permanenza</label>
                        <input id="max-stay" name="max_stay" type="number" class="form-control {{$errors->has('max_stay')?'is-invalid':null}}" placeholder="giorni" value="{{old('max_stay')}}">
                        <div class="invalid-feedback">
                            Inserire la durata massima del soggiorno
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Prezzo</h5>
            </div>
            <div class="card-body">
                <div class="card-block">
                    <div class="form-group">
                        <label for="price-per-night">Prezzo a notte Euro</label>
                        <input id="price-per-night" type="text" name="price_per_night" class="form-control {{$errors->has('price_per_night')?'is-invalid':null}}" placeholder="100.00" value="{{old('price_per_night')}}">
                        <div class="invalid-feedback">
                            Prezzo non valido
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sale">Sconto</label>
                        <input id="sale" type="number" name="sale" class="form-control {{$errors->has('sale')?'is-invalid':null}}" placeholder="%" value="{{old('sale')}}">
                        <div class="invalid-feedback">
                            Sconto non valido
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sale-price">Prezzo scontato Euro</label>
                        <input id="sale-price" class="form-control text-danger" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Visibilità</h5>
            </div>
            <div class="card-body">
                <div class="custom-control custom-switch">
                    <input type="checkbox" {{$errors->isEmpty()||old('is_showed')?'checked':null}} class="custom-control-input" name="is_showed" value="1" id="visibility">
                    <label class="custom-control-label" for="visibility">Rendi visibile non appena inserito</label>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Giorni riservati</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="" id="reserved_days_calendar"></div>
                    </div>
                    <div class="col-4">
                        <div class="mb-1">
                            <span class="text-muted">Elenco giorni riservati (doppio click per rimuovere):</span>
                        </div>
                        <div id="reserved_days_list">
                            @if(old('reserved_days'))
                                <ul>
                                    @foreach(old('reserved_days') as $day)
                                        <li class="reserved_day" data-value="{{$day}}">
                                            <input type="hidden" name="reserved_days[]" value="{{$day}}">{{\Carbon\Carbon::createFromFormat('Y-m-d', $day)->format('d-m-Y')}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Servizi</h5>
            </div>
            <div class="card-body">
                <span class="text-muted">Seleziona servizi da includere, inserisci il costo per notte se il servizio è a pagamento</span>
                <div class="upgrades_container">
                    @foreach($services as $service)
                        <div class="input-group my-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    @if(old('selected_services') && in_array($service->slug,old('selected_services')))
                                        <input type="checkbox" checked name="selected_services[]" value="{{$service->slug}}">
                                    @else
                                        <input type="checkbox" name="selected_services[]" value="{{$service->slug}}">
                                    @endif
                                </div>
                            </div>
                            <input type="text" class="form-control service" value="{{$service->name}}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">Euro</span>
                                @if(old('services_price'))
                                    <input name="services_price[{{$service->slug}}]" class="input-group-text service_price" type="text" value="{{old('services_price')[$service->slug]}}">
                                @else
                                    <input name="services_price[{{$service->slug}}]" class="input-group-text service_price" type="text">
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if(old('new_services_prices'))
                        @foreach(old('new_services_prices') as $serviceName => $servicePrice)
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="new_services[]" value="{{$serviceName}}" {{in_array($serviceName, old('new_services'))?'checked':null}}>
                                    </div>
                                </div>
                                <input type="text" class="form-control new_service" value="{{$serviceName}}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Euro</span>
                                    <input name="new_services_prices[{{$serviceName}}]" class="input-group-text" type="text" value="{{$servicePrice}}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <span class="text-muted">Aggiungi nuovi servizi</span>
                <div class="form-row mt-2">
                    <div class="col">
                        <input id="new_service_input" type="text" class="form-control" placeholder="nome servizio">
                        <div class="invalid-feedback">
                            Nome troppo corto o già presente
                        </div>
                    </div>
                    <div class="">
                        <button id="add_service" class="btn btn-primary px-5">Aggiungi</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="text-center">Immagini</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="image_container"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <span class="text-muted">Immagine principale</span>
                        <div class="input-group my-2">
                            <label class="form-control input_file_label {{$errors->has('main_image')?'is-invalid':null}}" data-index="0">
                                <span class="input_file_label_text">Scegli immagine</span>
                                <input type="file" data-index="0" name="main_image" class="custom_file_input" accept="image/x-png,image/jpeg">
                            </label>
                            <div class="input-group-append">
                                <span class="input-group-text open_input_file" data-index="0">Apri</span>
                            </div>
                            <div class="invalid-feedback">
                                Immagine principale non selezionata
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Immagini secondarie (4 max)</span>
                        @for($i=1;$i<=4;$i++)
                            <div class="input-group my-2">
                                <label class="form-control input_file_label" data-index="{{$i}}">
                                    <span class="input_file_label_text">Scegli immagine</span>
                                    <input type="file" data-index="{{$i}}" name="other_images[]" class="custom_file_input" accept="image/x-png,image/jpeg">
                                </label>
                                <div class="input-group-append">
                                    <span class="input-group-text open_input_file" data-index="{{$i}}">Apri</span>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success w-100 mt-2 p-2">Inserisci appartamento</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<script id="address-search-results-template" type="text/x-handlebars-template">
    <ul class="list-group mb-2">
        @{{#each this}}
        <button type="button" class="list-group-item list-group-item-action address_item" data-lat="@{{address_lat}}" data-lng="@{{address_lng}}">@{{address_name}}</button>
        @{{/each}}
    </ul>
</script>
<script id="no-results-template" type="text/x-handlebars-template">
    <span class="text-muted">Nessun risultato trovato</span>
</script>
<script id="reserved-days-template" type="text/x-handlebars-template">
    <ul>
        @{{#each this}}
        <li class="reserved_day" data-value="@{{this.id}}">
            <input type="hidden" name="reserved_days[]" value="@{{this.id}}">@{{this.value}}
        </li>
        @{{/each}}
    </ul>
</script>
<script id="new-service-template" type="text/x-handlebars-template">
    <div class="input-group my-2">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input type="checkbox" name="new_services[]" value="@{{service_name}}" checked>
            </div>
        </div>
        <input type="text" class="form-control new_service" value="@{{service_name}}" readonly>
        <div class="input-group-append">
            <span class="input-group-text">Euro</span>
            <input name="new_services_prices[@{{service_name}}]" class="input-group-text" type="text">
        </div>
    </div>
</script>
<script id="image-template" type="text/x-handlebars-template">
    <div class="image_frame image_frame_@{{image_index}}" style="background-image: url(@{{image_data}})">
        <div class="overlay">
            <span class="text">@{{overlay_text}}</span>
            <div class="remove_image" data-remove="@{{image_index}}">
                <i class="fas fa-trash"></i>
            </div>
        </div>
    </div>
</script>
