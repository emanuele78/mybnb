<div class="container apartments_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center main_title">I tuoi appartamenti</h3>
        </div>
        <div class="card-body">
            <div class="card-block">
                <div class="row">
                    <div class="dropdown col">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Visualizza
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item dropdown_show active" data-show="all_apartments" href="#">Tutti gli appartamenti</a>
                            <a class="dropdown-item dropdown_show" data-show="only_hidden_apartments" href="#">Solo appartamenti nascosti</a>
                            <a class="dropdown-item dropdown_show" data-show="only_visible_apartments" href="#">Solo appartamenti visibili</a>
                            <a class="dropdown-item dropdown_show" data-show="only_apartments_with_active_promo" href="#">Solo appartamenti con promozioni attive</a>
                            <a class="dropdown-item dropdown_show" data-show="only_apartments_without_active_promo" href="#">Solo appartamenti senza promozioni attive</a>
                        </div>
                    </div>
                    <div class="dropdown col text-right">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownOrderMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ordina
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownOrderMenuButton">
                                <a class="dropdown-item dropdown_order active" data-order="title" href="#">Nome appartamento</a>
                                <a class="dropdown-item dropdown_order" data-order="created_at" href="#">Data creazione</a>
                                <a class="dropdown-item dropdown_order" data-order="updated_at" href="#">Data ultima modifica</a>
                                <a class="dropdown-item dropdown_order" data-order="created_at_desc" href="#">Data creazione (ultimi per primi)</a>
                                <a class="dropdown-item dropdown_order" data-order="updated_at_desc" href="#">Data ultima modifica (ultimi per primi)</a>
                            </div>
                        </div>
                        <a href="{{route('new_apartment')}}" class="btn btn-success ml-3">Inserisci un nuovo appartamento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content_wrapper mb-4"></div>
</div>

@component('components.no_result_template')
    Nessun appartamento trovato
@endcomponent

@component('components.modal_action')
    @slot('modal_title','Conferma cancellazione')
    @slot('modal_dismiss_button_text','Annulla')
    @slot('modal_confirm_button_text','Cancella')
    Confermi la cancellazione di questo appartamento e di tutti i dati associati ad esso?
@endcomponent

<script id="apartment-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card mt-3 apartment-card-@{{slug}}">
        <div class="row no-gutters row_card_content">
            <div class="col-4">
                <img src="{{asset('img/apartments')}}/@{{image}}" class="card-img" alt="">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <small class="card-text text-muted">Titolo appartamento</small>
                            <div class="">
                                <a href="{{route('show')}}/@{{slug}}" class="card-text mb-0">@{{title}}</a>
                            </div>
                            <small class="card-text text-muted d-block">Prezzo:
                                <strong>Euro @{{#processAmount}}@{{full_price_per_night}}@{{/processAmount}}</strong>
                            </small>
                            @{{#if in_sale}}
                            <small class="card-text text-muted d-block">Prezzo scontato:
                                <strong class="text-danger">Euro @{{sale_price}}</strong>
                            </small>
                            @{{/if}}
                            <small class="card-text text-muted d-block">Data creazione:
                                <strong>@{{created_at}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Data ultima modifica:
                                <strong>@{{updated_at}}</strong>
                            </small>
                            @{{#if is_visible}}
                            <small class="card-text text-muted d-block">Stato:
                                <strong>visibile</strong>
                            </small>
                            @{{else}}
                            <small class="card-text text-muted d-block">Stato:
                                <strong class="text-danger">non visibile</strong>
                            </small>
                            @{{/if}}
                            @{{#if active_promotion}}
                            <small class="card-text text-muted d-block">Promozione attiva:
                                <strong class="text-danger">@{{active_promotion}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Iniziata il:
                                <strong class="text-danger">@{{active_promotion_start}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Finisce il:
                                <strong class="text-danger">@{{active_promotion_end}}</strong>
                            </small>
                            @{{/if}}
                        </div>
                        <div class="col-4 text-right">
                            <div class="">
                                <button data-ref="{{route('promote','apartment')}}" data-apartment="@{{slug}}" class="btn btn-warning promote_apartment">Sponsorizza</button>
                            </div>
                            <div class="mt-2">
                                <button data-ref="{{route('edit_apartment','apartment')}}" data-apartment="@{{slug}}" class="btn btn-primary edit_apartment">Modifica</button>
                            </div>
                            <div class="mt-2">
                                @{{#if is_visible}}
                                <button class="btn btn-danger hide_apartment" data-apartment="@{{slug}}">Nascondi</button>
                                @{{else}}
                                <button class="btn btn-success show_apartment" data-apartment="@{{slug}}">Rendi visibile</button>
                                @{{/if}}
                            </div>
                            <div class="mt-2">
                                <button data-apartment="@{{slug}}" class="btn btn-danger delete_apartment">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="waiting @{{slug}} collapse">
            <div class="loading_wrapper">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
        </div>
    </div>
    @{{/each}}
</script>