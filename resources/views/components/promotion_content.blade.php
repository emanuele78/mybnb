<div class="container promotion_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center">Promuovi il tuo appartamento</h3>
        </div>
        <div class="row no-gutters row_card_content mt-2">
            <div class="col-12 col-sm-4">
                <img src="{{asset('img/apartments')}}/{{$apartment->main_image}}" class="card-img" alt="">
            </div>
            <div class="col-12 col-sm-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-8">
                            <small class="card-text text-muted apartment_title" data-apartment="{{$apartment->slug}}">Titolo appartamento</small>
                            <div class="">
                                <a href="{{route('show').'/'.$apartment->slug}}" class="card-text mb-0">{{$apartment->title}}</a>
                            </div>
                            @if($activePromotion)
                                <small class="card-text text-muted d-block">Promozione attiva:
                                    <strong class="text-danger">{{ucfirst($activePromotion->promotion_plan->name)}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Iniziata il:
                                    <strong class="text-danger">{{\App\Utility::dateTimeLocale($activePromotion->start_at, true)}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Finisce il:
                                    <strong class="text-danger">{{\App\Utility::dateTimeLocale($activePromotion->end_at, true)}}</strong>
                                </small>
                            @endif
                        </div>
                        <div class="col-12 col-sm-4 text-right">
                            <div class="mt-1">
                                <button class="btn btn-primary expand_promo_list" data-toggle="collapse" data-target="#promo_list" aria-expanded="true">Mostra elenco promozioni</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="promo_list" class="card mt-3 collapse">
        <div class="card-header">
            <h4 class="text-center">Promozioni attivate</h4>
        </div>
        <div class="card-body">
            <div class="list_wrapper">
                @foreach($promotionsList as $promotion)
                    <div class="promo_wrapper">
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <small class="card-text text-muted d-block">Creata il giorno:
                                    <strong>{{\App\Utility::dateTimeLocale($promotion['created_at'], false)}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Tipo promozione:
                                    <strong>{{$promotion['promotion_plan']['name']}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Inizio:
                                    <strong>{{\App\Utility::dateTimeLocale($promotion['start_at'], false)}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Fine:
                                    <strong>{{\App\Utility::dateTimeLocale($promotion['end_at'], false)}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Totale giorni:
                                    <strong>{{\App\Utility::diffInDays($promotion['start_at'], $promotion['end_at'])}}</strong>
                                </small>
                                <small class="card-text text-muted d-block">Importo pagato:
                                    <strong>Euro {{number_format(\App\Utility::diffInDays($promotion['start_at'],$promotion['end_at'])*$promotion['promotion_plan']['price_per_day'],2,',','.')}}</strong>
                                </small>
                            </div>
                            <div class="col-12 col-sm-6 mt-1 text-right">
                                <a href="{{route('show_promo_receipt',$promotion['reference'])}}" class="btn btn-success download_receipt" download>Scarica ricevuta</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card mt-3 mb-5 promo_detail">
        <div class="card-header">
            <h4 class="text-center">Attiva una nuova promozione</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p class="text-muted">Attivando una promozione, il tuo appartamento verrà visualizzato nella home page.</p>
                    <p class="text-muted">Scegli il tipo di promozione:</p>
                    @foreach($plans as $plan)
                        <div class="promo_type_card ml-4 mt-2 {{$loop->first?'active':null}}" data-max_length="{{$plan['max_length']}}" data-card_type="{{$plan['card_type']}}">
                            <span class="promo_title text-primary">{{ucfirst($plan['name'])}}</span>
                            <span class="text-muted promo_price" data-price="{{$plan['price_per_day']}}">Euro {{number_format($plan['price_per_day'],2,',','.')}}/giorno</span>
                            <div class="promo_image" style="background-image: url('{{asset('img/promotion').'/'.$plan['image']}}')"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-muted mt-3">Scegli quando iniziare la promozione:</p>
                    <div class="pl-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="start_promo_radio" id="start_now" value="start_now" checked>
                            <label class="form-check-label" for="start_now">
                                inizia subito
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="start_promo_radio" id="start_at" value="start_date">
                            <label class="form-check-label" for="start_at">
                                inizia il
                            </label>
                            <input type="text" class="form-control flatpicker flatpickr-input text-center w-auto" placeholder="Scegli" name="start_at" readonly="readonly">
                            <div class="invalid-feedback start_promo_input"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="text-muted mt-3">Scegli per quanti giorni vuoi promuovere il tuo appartamento:
                        <select class="custom-select w-auto ml-4 mt-2 promo_length d-block"></select>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h5 class="p-2">Totale Euro
                        <span class="amount"></span>
                    </h5>
                </div>
                <div class="col-12 col-sm-6 text-right">
                    <button type="button" class="btn btn-success px-5 button_proceed">Procedi</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3 mb-5 payment_module collapse">
        @component('components.payment_form')
            <div class="card-footer payment_footer">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary px-5 back_button">Indietro</button>
                    </div>
                </div>
            </div>
        @endcomponent
    </div>
</div>
<script id="length-template" type="text/x-handlebars-template">
    @{{#each this}}
    <option name="promo_length" value="@{{this}}">@{{this}}</option>
    @{{/each}}
</script>