<div class="container bookings_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center main_title"></h3>
        </div>
        <div class="card-body">
            <div class="card-block">
                <div class="row">
                    <div class="dropdown col">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Visualizza
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item dropdown_show active" data-show="my_apartments_bookings" href="#">Prenotazioni ricevute</a>
                            <a class="dropdown-item dropdown_show" data-show="other_apartments_bookings" href="#">Prenotazioni fatte</a>
                            <a class="dropdown-item dropdown_show" data-show="other_apartments_bookings_pending" href="#">Prenotazioni fatte (da confermare)</a>
                        </div>
                    </div>
                    <div class="dropdown col text-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filtra
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item dropdown_filter" data-filter="only_future_bookings" href="#">Solo prenotazioni future</a>
                            <a class="dropdown-item dropdown_filter active" data-filter="all_bookings" href="#">Tutte le prenotazioni</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content_wrapper"></div>
</div>

@component('components.no_result_template')
    Nessuna prenotazione trovata
@endcomponent

<script id="own-apartments-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card mt-3 single_booking">
        <div class="row no-gutters">
            <div class="col-12 col-sm-4">
                @{{#if apartment_active}}
                <img src="{{asset('img/apartments')}}/@{{apartment_image}}" class="card-img" alt="">
                @{{else}}
                <img src="{{asset('img/apartments/no_image.jpg')}}" class="card-img" alt="">
                @{{/if}}
            </div>
            <div class="col-12 col-sm-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <small class="card-text text-muted">Appartamento prenotato</small>
                            <div class="">
                                @{{#if apartment_active}}
                                <a href="{{route('show')}}/@{{apartment_slug}}" class="card-text mb-0">@{{apartment_title}}</a>
                                @{{else}}
                                <span class="card-text mb-0">@{{apartment_title}}</span>
                                @{{/if}}
                            </div>
                            @{{#unless apartment_active}}
                            <span class="badge badge-pill badge-danger">Appartamento non più registrato</span>
                            @{{/unless}}
                        </div>
                        <div class="col-12 col-md-4 text-right">
                            <div class="">
                                <button class="btn btn-primary expand_booking_list" data-toggle="collapse" data-target="#@{{apartment_slug}}" aria-expanded="true">Mostra elenco prenotazioni</button>
                            </div>
                            <div class="mt-1">
                                <button class="btn btn-success expand_calendar" data-toggle="collapse" data-target="#calendar-section-@{{apartment_slug}}" aria-expanded="true">Mostra calendario prenotazioni</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="calendar-section-@{{apartment_slug}}" class="collapse">
            <div class="card-body">
                <div class="apartment_calendar_wrapper">
                    <div class="row">
                        <div class="col" id="calendar-@{{apartment_slug}}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="@{{apartment_slug}}" class="collapse">
            <div class="card-body pt-0 booking_section">
                @{{#each this.bookings}}
                <div class="booking_wrapper">
                    <hr>
                    <div class="row">
                        <div class="col">
                            <small class="card-text text-muted d-block">Effettuata da:
                                <strong>@{{user_fullname}} (@{{user_nickname}})</strong>
                            </small>
                            <small class="card-text text-muted d-block">Giorno/ora:
                                <strong>@{{this.confirmed_at}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Email:
                                <strong>@{{this.user_email}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Check-in:
                                <strong>@{{this.check_in}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Check-out:
                                <strong>@{{this.check_out}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Numero notti:
                                <strong>@{{this.nights_count}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Importo totale:
                                <strong>Euro @{{#processAmount}}@{{this.total_amount}}@{{/processAmount}}</strong>
                            </small>
                        </div>
                        <div class="col text-right">
                            <small class="card-text text-muted d-block">Servizi a pagamento sottoscritti:</small>
                            @{{#each this.upgrades}}
                            <small class="card-text text-muted d-block">
                                <strong class="text-capitalize">@{{service_name}}</strong>
                            </small>
                            @{{/each}}
                        </div>
                    </div>
                </div>
                @{{/each}}
            </div>
        </div>
    </div>
    @{{/each}}
</script>

<script id="other-apartments-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card mt-3 single_booking">
        <div class="row no-gutters">
            <div class="col-12 col-sm-4">
                @{{#if apartment_active}}
                <img src="{{asset('img/apartments')}}/@{{apartment_image}}" class="card-img" alt="">
                @{{else}}
                <img src="{{asset('img/apartments/no_image.jpg')}}" class="card-img" alt="">
                @{{/if}}
            </div>
            <div class="col-12 col-sm-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <small class="card-text text-muted">Appartamento prenotato</small>
                            <div class="">
                                @{{#if apartment_active}}
                                <a href="{{route('show')}}/@{{apartment_slug}}" class="card-text mb-0">@{{apartment_title}}</a>
                                @{{else}}
                                <span class="card-text mb-0">@{{apartment_title}}</span>
                                @{{/if}}
                            </div>
                            @{{#unless apartment_active}}
                            <div class="">
                                <span class="badge badge-pill badge-danger">Appartamento non più registrato</span>
                            </div>
                            @{{/unless}}
                            <small class="card-text text-muted">Proprietario</small>
                            <p class="card-text mb-0">@{{apartment_owner_fullname}}
                                <small class="card-text text-muted">(@{{apartment_owner_nickname}})</small>
                            </p>
                            <small class="card-text text-muted">@{{apartment_owner_email}}</small>
                        </div>
                        <div class="col-12 col-md-4 text-right">
                            <div class="">
                                <button class="btn btn-primary expand_booking_made" data-toggle="collapse" data-target="#@{{apartment_slug}}" aria-expanded="true">Mostra prenotazioni fatte</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="@{{apartment_slug}}" class="collapse">
            <div class="card-body booking_section pt-0">
                @{{#each this.bookings}}
                <div class="">
                    <hr>
                    <div class="row">
                        <div class="col">
                            <small class="card-text text-muted d-block">Hai prenotato il giorno/ora:
                                <strong>@{{this.confirmed_at}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Check-in:
                                <strong>@{{this.check_in}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Check-out:
                                <strong>@{{this.check_out}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Numero notti:
                                <strong>@{{this.nights_count}}</strong>
                            </small>
                            <small class="card-text text-muted d-block">Importo totale:
                                <strong>Euro @{{#processAmount}}@{{this.total_amount}}@{{/processAmount}}</strong>
                            </small>
                        </div>
                        <div class="col text-right">
                            <small class="card-text text-muted d-block">Servizi a pagamento sottoscritti:</small>
                            @{{#each this.upgrades}}
                            <small class="card-text text-muted d-block">
                                <strong class="text-capitalize">@{{service_name}}</strong>
                            </small>
                            @{{/each}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        @{{#ifCond this.status}}
                        <a href="{{route('show_receipt')}}/@{{booking_reference}}" class="btn btn-success mt-2 booking_made_receipt" download>Scarica ricevuta</a>
                        @{{else}}
                        <a href="{{route('resume_booking','booking')}}" role="button" data-booking="@{{booking_reference}}" class="btn btn-warning resume_booking mt-2">Riprendi prenotazione</a>
                        @{{/ifCond}}
                    </div>
                </div>
                @{{/each}}
            </div>
        </div>
    </div>
    @{{/each}}
</script>
@component('components.modal_info')
    @slot('modal_title','Dettagli prenotazione')
    @slot('modal_confirm_button_text','Ok')
    <div id="info_booking_content"></div>
@endcomponent
<script id="info-booking-template" type="text/x-handlebars-template">
    <div class="row">
        <div class="col">
            <small class="card-text text-muted d-block">Effettuata da:
                <strong>@{{user_fullname}} (@{{user_nickname}})</strong>
            </small>
            <small class="card-text text-muted d-block">Giorno/ora:
                <strong>@{{confirmed_at}}</strong>
            </small>
            <small class="card-text text-muted d-block">Email:
                <strong>@{{user_email}}</strong>
            </small>
            <small class="card-text text-muted d-block">Check-in:
                <strong>@{{check_in}}</strong>
            </small>
            <small class="card-text text-muted d-block">Check-out:
                <strong>@{{check_out}}</strong>
            </small>
            <small class="card-text text-muted d-block">Numero notti:
                <strong>@{{nights_count}}</strong>
            </small>
            <small class="card-text text-muted d-block">Importo totale:
                <strong>Euro @{{#processAmount}}@{{this.total_amount}}@{{/processAmount}}</strong>
            </small>
        </div>
        <div class="col">
            <div class="col text-right">
                <small class="card-text text-muted d-block">Servizi a pagamento sottoscritti:</small>
                @{{#each this.upgrades}}
                <small class="card-text text-muted d-block">
                    <strong class="text-capitalize">@{{service_name}}</strong>
                </small>
                @{{/each}}
            </div>
        </div>
    </div>
</script>
