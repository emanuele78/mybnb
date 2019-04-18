<div class="container my-3">
    <div class="row payment_section">
        <div class="wrapper col">
            <div class="card card_payment">
                <div class="panel panel-default bootstrap-basic">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inserisci i dettagli della carta</h3>
                    </div>
                    <form class="panel-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="control-label">Numero carta</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="card-number"></div>
                                <span class="helper-text"></span>
                            </div>
                            <div class="form-group col-3">
                                <label class="control-label">Scadenza</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="expiration-month"></div>
                                <div class="form-control" id="expiration-year"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="control-label">Codice di sicurezza</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="cvv"></div>
                            </div>
                            <div class="form-group col-6">
                                <label class="control-label">Zipcode</label>
                                <!--  Hosted Fields div container -->
                                <div class="form-control" id="postal-code"></div>
                            </div>
                        </div>

                        <button value="submit" id="submit" class="btn btn-success btn-lg center-block">Paga con
                            <span id="card-type">carta</span>
                        </button>
                    </form>
                </div>
                <div class="card_payment_overlay">
                    <div class="loading_wrapper">
                        <i class="fas fa-spinner fa-pulse"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row payment_result my-3 collapse">
        <div class="wrapper col">
            <div class="card">
                <div class="card-body element_result">
                    <div class="alert text-center">
                        <span class="payment_result_message"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>