<div class="container my-3">
    <div class="row">
        <div class="wrapper col">
            <div class="card">

                <div class="panel panel-default bootstrap-basic">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inserisci i dettagli della carta</h3>
                    </div>
                    <form class="panel-body">
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <label class="control-label">Numero carta</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="card-number"></div>
                                <span class="helper-text"></span>
                            </div>
                            <div class="form-group col-sm-4">
                                <div class="row">
                                    <label class="control-label col-xs-12">Scadenza</label>
                                    <div class="col-xs-6">
                                        <!--  Hosted Fields div container -->
                                        <div class="form-control" id="expiration-month"></div>
                                    </div>
                                    <div class="col-xs-6">
                                        <!--  Hosted Fields div container -->
                                        <div class="form-control" id="expiration-year"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label">Codice di sicurezza</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="cvv"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Zipcode</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="postal-code"></div>
                            </div>
                        </div>

                        <button value="submit" id="submit" class="btn btn-success btn-lg center-block">Pay with
                            <span id="card-type">Card</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>