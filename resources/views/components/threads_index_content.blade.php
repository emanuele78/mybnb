<div class="container threads_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center main_message_title"></h3>
        </div>
        <div class="card-body">
            <div class="card-block">
                <div class="row">
                    <div class="dropdown col">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Visualizza conversazioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item {{$show_by == 'my_apartments' ? 'active':null}}" data-type="my_apartments" href="#">Relative ai miei appartamenti</a>
                            <a class="dropdown-item {{$show_by == 'other_apartments' ? 'active':null}}" data-type="other_apartments" href="#">Relative ad altri appartamenti</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content_wrapper"></div>
</div>

@component('components.no_result_template')
    Nessuna conversazione trovata
@endcomponent

<script id="own-apartments-template" type="text/x-handlebars-template">
    @{{#each this as |apartment|}}
    <div class="card mt-3 single_apartment">
        <div class="row no-gutters">
            <div class="col-4">
                <img src="{{asset('img/apartments')}}/@{{apartment_image}}" class="card-img" alt="">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <small class="card-text text-muted">Conversazioni per l'appartamento</small>
                            <div class="">
                                <a href="{{route('show')}}/@{{apartment_slug}}" class="card-text mb-0">@{{apartment_title}}</a>
                            </div>
                            @{{#if this.apartment_has_new_messages}}
                            <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                            @{{/if}}
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-primary toggle_text" data-toggle="collapse" data-target="#@{{apartment_slug}}" aria-expanded="true">Mostra conversazioni</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="@{{apartment_slug}}" class="collapse">
            <div class="card-body apartment_threads_section">
                @{{#each this.threads}}
                <div id="thread_section_@{{this.thread_reference}}">
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <small class="card-text text-muted">Conversazione con</small>
                            <p class="card-text mb-0">@{{this.with_user}}</p>
                            <small class="card-text text-muted">Ultimo messaggio il @{{this.last_message}}</small>
                            @{{#if this.has_new_messages}}
                            <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                            @{{/if}}
                        </div>
                        <div class="col-9 text-right">
                            <a href="{{route('show_thread')}}/@{{this.thread_reference}}?show_by=my_apartments" class="btn btn-success" role="button" aria-pressed="true">Mostra conversazione</a>
                            <button type="button" data-thread="@{{this.thread_reference}}" class="btn btn-danger delete_my_apartments_thread" role="button">Elimina conversazione</button>
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
    <div class="card mt-3 single_apartment">
        <div class="row no-gutters">
            <div class="col-4">
                <img src="{{asset('img/apartments')}}/@{{apartment_image}}" class="card-img" alt="">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <small class="card-text text-muted mb-0">Conversazioni per l'appartamento</small>
                            <div class="">
                                <a href="{{route('show')}}/@{{apartment_slug}}" class="card-text mb-0">@{{apartment_title}}</a>
                            </div>
                            @{{#if this.has_new_messages}}
                            <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                            @{{/if}}
                        </div>
                        <div class="col-4 text-right">
                            <small class="card-text text-muted">Proprietario</small>
                            <p class="card-text mb-0">@{{apartment_owner}}</p>
                            <a href="{{route('show_thread')}}/@{{this.thread_reference}}?show_by=other_apartments" class="btn btn-success mt-2" role="button" aria-pressed="true">Mostra conversazione</a>
                            <button type="button" data-thread="@{{this.thread_reference}}" class="btn btn-danger mt-2 delete_other_apartments_thread">Elimina conversazione</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @{{/each}}
</script>