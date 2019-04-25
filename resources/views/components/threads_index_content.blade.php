<div class="container threads_container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center main_message_title">Messaggi per i tuoi appartamenti</h3>
        </div>
        <div class="card-body">
            <div class="card-block">
                <div class="row">
                    <div class="dropdown col-6">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Visualizza conversazioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item active" data-type="my_apartment" href="#">Relative ai miei appartamenti</a>
                            <a class="dropdown-item" data-type="other_apartments" href="#">Relative ad altri appartamenti</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="search_message">
                            <input type="email" class="form-control" id="search_message" placeholder="Cerca nelle conversazioni">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content_wrapper"></div>
</div>

<script id="no-results-template" type="text/x-handlebars-template">
    <div class="card mt-3">
        <div class="card-body">
            Nessun risultato trovato
        </div>
    </div>
</script>

<script id="apartments-template" type="text/x-handlebars-template">
    @{{#each this as |apartment|}}
    <div class="card mt-3">
        <div class="row no-gutters">
            <div class="col-4">
                <img src="{{asset('img/apartments')}}/@{{image}}" class="card-img" alt="">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <small class="card-text text-muted">Conversazioni per l'appartamento</small>
                            <p class="card-text mb-0">@{{title}}</p>
                            @{{#if this.unreaded_messages}}
                            <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                            @{{/if}}
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-primary toggle_text" data-toggle="collapse" data-target="#@{{slug}}" aria-expanded="true">Mostra conversazioni</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="@{{slug}}" class="collapse">
            <div class="card-body">
                @{{#each this.messages}}
                <hr>
                <div class="row">
                    <div class="col-3">
                        <small class="card-text text-muted">Conversazione con</small>
                        <p class="card-text mb-0">@{{this.sender}}</p>
                        @{{#if this.unreaded}}
                        <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                        @{{/if}}
                    </div>
                    <div class="col-9 text-right">
                        <a href="{{route('show_thread').'?apartment='}}@{{@apartment.slug}}{{'&with='}}@{{this.sender}}" class="btn btn-success" role="button" aria-pressed="true">Mostra conversazione</a>
                        <a href="#" class="btn btn-danger" role="button" aria-pressed="true">Elimina conversazione</a>
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
    <div class="card mt-3">
        <div class="row no-gutters">
            <div class="col-4">
                <img src="{{asset('img/apartments')}}/@{{image}}" class="card-img" alt="">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <small class="card-text text-muted mb-0">Conversazioni per l'appartamento</small>
                            <p class="card-text mb-0">@{{title}}</p>
                            @{{#if this.unreaded_messages}}
                            <span class="badge badge-pill badge-warning">nuovi messaggi</span>
                            @{{/if}}
                        </div>
                        <div class="col-4 text-right">
                            <small class="card-text text-muted">Proprietario</small>
                            <p class="card-text mb-0">@{{owner}}</p>
                            <a href="{{route('show_thread').'?apartment='}}@{{this.slug}}" class="btn btn-success mt-2" role="button" aria-pressed="true">Mostra conversazione</a>
                            <button href="{{route('show_thread').'?apartment='}}@{{this.slug}}" class="btn btn-danger mt-2" aria-pressed="true">Elimina conversazione</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @{{/each}}
</script>