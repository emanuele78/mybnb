<div class="container search_results_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center">Cerca appartamenti</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col">
                    <label for="city" class="text-muted">Città di destinazione:</label>
                    <select id="city" class="form-control">
                        @foreach($citiesList as $id => $city)
                            <option {{$userSearch['city_code']==$id?'selected':null}} value="{{$id}}">{{$city['name']}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Seleziona una città dalla lista
                    </div>
                </div>
                <div class="col">
                    <label for="check_in" class="text-muted">Arrivo:</label>
                    <input type="text" class="form-control mr-2 flatpicker flatpickr-input text-center {{$errors->has('check_in')?'is-invalid':null}}" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly" value="{{$userSearch['check_in']?:null}}">
                    <div class="invalid-feedback">
                        Controlla la data del check-in
                    </div>
                </div>
                <div class="col">
                    <label for="check_out" class="text-muted">Partenza:</label>
                    <input type="text" class="form-control mr-2 flatpicker flatpickr-input text-center {{$errors->has('check_out')?'is-invalid':null}}" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly" value="{{$userSearch['check_out']?:null}}">
                    <div class="invalid-feedback">
                        Controlla la data del check-out
                    </div>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col">
                    <label for="people" class="text-muted">Persone:</label>
                    <select id="people" name="people" class="form-control">
                        @for($i=1;$i<=$maxPeople;$i++)
                            <option {{$i==2?'selected':null}} value="{{$i}}">{{$i<$maxPeople?$i:'10+'}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <label for="radius_slider" class="text-muted">Raggio di ricerca:
                        <span class="km_radius text-primary"></span></label>
                    <div class="form-group text-center">
                        <input id="radius_slider" data-slider-id="radius_sliderSlider" type="text" data-slider-min="{{$radiusKmData['min']}}" data-slider-max="{{$radiusKmData['max']}}" data-slider-step="{{$radiusKmData['step']}}" data-slider-value="{{$radiusKmData['default']}}"/>
                    </div>
                </div>
                <div class="col">
                    <label for="price_slider" class="text-muted">Range di prezzo:
                        <span class="price_range text-primary"></span></label>
                    <div class="form-group text-center">
                        <input id="price_slider" type="text" value="" data-slider-min="{{$priceRangeData['min']}}" data-slider-max="{{$priceRangeData['max']}}" data-slider-step="{{$priceRangeData['step']}}" data-slider-value="[{{$priceRangeData['default']['start']}},{{$priceRangeData['default']['end']}}]"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="wrapper col-3">
            <div class="card">
                <div class="card-header">
                    <h6>Servizi</h6>
                </div>
                <div class="card-body">
                    @foreach($availableServices as $availableService)
                        <div class="form-check mt-2">
                            <input class="form-check-input service_checkbox" type="checkbox" value="{{$availableService->slug}}" id="{{$availableService->slug}}">
                            <label class="form-check-label" for="{{$availableService->slug}}">
                                {{ucfirst($availableService->name)}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="wrapper col-9">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="row">
                        <div class="col">
                            <span class="text-muted">Risultati trovati: <span class="font-weight-bold text-primary results_count"></span></span>
                        </div>
                        <div class="col text-right">
                            <span class="text-muted pr-4">Ordina per</span>
                            <span class="order_by active font-weight-bold text-primary" data-value="distance">Distanza</span>
                            <span class="order_by font-weight-bold text-primary" data-value="price_per_night">Prezzo</span>
                            <span class="order_by font-weight-bold text-primary" data-value="square_meters">Metri quadri</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="results_wrapper mb-5"></div>
        </div>
    </div>
</div>
<script id="apartment-card-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card apartment_result_card mt-2">
        <div class="row no-gutters">
            <div class="col-4">
                <div class="card_image" style="background-image: url('{{asset('img/apartments')}}/@{{main_image}}')"></div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-8">
                        <div class="card-body">
                            <small class="card-text text-muted">Titolo appartamento</small>
                            <div class="">
                                <a href="{{route('show')}}/@{{slug}}" class="card-text font-weight-bold title_ellipsis">@{{title}}</a>
                            </div>
                            <small class="card-text text-muted d-block">Metri quadri:
                                <strong>@{{square_meters}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Prezzo:
                                <strong>Euro @{{#processAmount}}@{{price_per_night}}@{{/processAmount}}</strong>
                            </small>
                            @{{#if sale}}
                            <small class="card-text text-muted d-block">Prezzo scontato:
                                <strong class="text-danger">Euro @{{#processSale}}@{{@index}}@{{/processSale}}</strong>
                            </small>
                            @{{/if}}
                            <small class="card-text text-muted d-block">Data inserimento:
                                <strong>@{{created_at}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Distanza dal luogo di ricerca:
                                <strong>@{{#processDistance}}@{{distance}}@{{/processDistance}} km</strong>
                            </small>
                        </div>
                    </div>
                    <div class="col-4 text-right mt-4">
                        <button data-apartment="" class="btn btn-success mr-4">Prenota</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @{{/each}}
</script>
<script id="loading-template" type="text/x-handlebars-template">
    <div class="card mt-2 loading_card">
        <div class="card-header border-bottom-0 py-4 loading_icon">
            <i class="fas fa-spinner fa-pulse"></i>
        </div>
    </div>
</script>