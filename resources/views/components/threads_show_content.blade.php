<div class="container">
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="text-center">I tuoi messaggi</h3>
        </div>
        <div class="card-body">
            <div class="card-block">
                <div class="row">
                    <div class="dropdown col-6">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mostra conversazioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item active" data-type="own_apartments" href="#">Relative ai miei appartamenti</a>
                            <a class="dropdown-item" data-type="other_apartments" href="#">Relative ad appartamenti di altri</a>
                            {{--<a class="dropdown-item" data-type="date" href="#">Per data ricezione</a>--}}
                            {{--<a class="dropdown-item" data-type="started_by_other" href="#">Solo conversazioni in risposta</a>--}}
                            {{--<a class="dropdown-item" data-type="started_by_me" href="#">Solo conversazioni iniziate da te</a>--}}
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
</div>

<div class="container loaded_message_container">

    <div class="row mt-2">
        <div class="wrapper col">
            <div class="card mb-3">
                <div class="row no-gutters message_item">
                    <div class="col-3">
                        <img src="{{asset('img/apartments/image1.jpg')}}" class="card-img" alt="">
                    </div>
                    <div class="col-9">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <small class="card-text text-muted">Messaggi per l'appartamento</small>
                                    <p class="card-text mb-0">Bellissimo appartamento in montagna</p>
                                    <small class="card-text text-muted">Conversazione iniziata da te, hai chiesto informazioni a</small>
                                    <p class="card-text mb-0">Gino</p>
                                    <small class="card-text text-muted">Ultimo messaggio il</small>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-danger">Elimina conversazione</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script id="entry-template" type="text/x-handlebars-template">
    <div class="row mt-2">
        <div class="wrapper col">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-3">
                        <img src="{{asset('img/apartments/image1.jpg')}}" class="card-img" alt="">
                    </div>
                    <div class="col-9">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title">Bellissimo appartamento in montagna</h5>
                                    <p class="card-text">Conversazione iniziata da te</p>
                                    <p class="card-text">
                                        <small class="text-muted">Ultimo messaggio il</small>
                                    </p>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-danger">Elimina conversazione</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>