<div class="container mb-3 my-3">
    <div class="card">
        <div class="card-header text-center">
            <h3>Informazioni sull'utilizzo della presente demo</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="offset-1 col-10">
                    <p class="text-muted">
                        <strong>Gentile Utente,</strong>
                    </p>
                    <p class="text-muted">sono lieto che tu abbia intenzione di utilizzare questa demo. Affinché tu possa continuare è necessario un
                        <strong>token</strong>.
                    <p class="text-muted">Per ricevere il
                        <strong>token</strong> basta inserire una mail valida nel campo sottostante ed entro qualche secondo lo riceverai all'indirizzo indicato.
                    </p>
                    <p class="text-muted">Il
                        <strong>token</strong> ti consente di utilizzare la mia web app in piena libertà per {{config('project.token_expiration_time')}} minuti dopodiché sarà necessario richiederne uno nuovo.
                    </p>
                    <p class="text-muted">
                        <strong>Ricorda, l'indirizzo e-mail inserito non sarà utilizzato per fini di marketing né ceduto a terzi.</strong>
                    </p>
                    <p class="text-muted">Questa demo è realizzata a solo scopo dimostrativo e fa parte del mio portfolio. I contenuti in essa presenti non sono veri.</p>
                    <p class="text-muted">Per garantire un'esperienza ottimale, ogni giorno eventuali dati inseriti saranno automaticamente distrutti e rimpiazzati con quelli di default</p>
                </div>
            </div>
            <div class="offset-1 col-10">
                <span class="text-primary">Se necessiti di un token, inserisci il tuo indirizzo email</span>
                <form action="#" class="form-inline">
                    <input type="email" class="form-control mr-2" id="email" placeholder="Indirizzo email" required>
                    <button id="request_token_button" type="submit" class="btn btn-primary my-2">Richiedi token</button>
                    <div class="invalid-feedback">
                        <span class="error_message"></span>
                    </div>
                </form>
                <label class="form-check-label text-muted" for="agreement_check">Dichiaro di accettare&nbsp<a href="{{route('show_privacy')}}"><strong>l'accordo di licenza</strong></a></label>
                <input type="checkbox" class="form-check-input ml-2" id="agreement_check">
            </div>
            <div class="offset-1 col-10 my-2">
                <div class="collapse" id="loading-element">
                    <div class="card bg-info text-center">
                        <div id="card-loading" class="card-body">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset-1 col-10 my-2">
                <span class="text-primary">Se già possiedi il token, inseriscilo qui</span>
                <form action="#" method="POST" class="form-inline" id="activation_form">
                    @csrf
                    @method('PATCH')
                    <input id="token_code" type="text" class="form-control mr-2" id="token" placeholder="Token" required>
                    <button id="activate_token_button" type="submit" class="btn btn-success my-2">Inizia a utilizzare l'app</button>
                </form>
            </div>
        </div>
    </div>
</div>