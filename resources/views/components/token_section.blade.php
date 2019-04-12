<div class="container mb-3 my-3">
    <div class="card">
        <div class="card-header text-center">
            <h3>Informazioni sull'utilizzo della presente web app</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="offset-1 col-10">
                    <p>Gentile Utente,</p>
                    <p>sono lieto che tu abbia intenzione di utilizzare questa app. Affinché tu possa continuare è necessario un token.
                    <p>Per ricevere il token basta inserire una mail valida nel campo sottostante ed entro qualche secondo riceverai lo riceverai all'indirizzo indicato.</p>
                    <p>Il token ti consente di utilizzare la mia web app in piena libertà per 15 minuti dopodiché sarà necessario richiederne uno nuovo. Ricorda, l'indirizzo e-mail inserito non sarà utilizzato per fini di marketing né ceduto a terzi.</p>
                    <p>Questa web app è stata realizzata a solo scopo dimostrativo e fa parte del mio portfolio. I contenuti in essa presenti non sono veri.</p>
                    <p>Per garantire un'esperienza ottimale, periodicamente eventuali dati inseriti come nuovi appartamenti o utenti creati saranno automaticamente distrutti e ripristinati quelli di default</p>
                </div>
            </div>
            <div class="offset-1 col-10 my-3">
                <h5>Se necessiti di un token, inserisci il tuo indirizzo email nel campo sottostante</h5>
                <form action="#" class="form-inline">
                    <input type="email" class="form-control mr-2" id="email" placeholder="Indirizzo email" required>
                    <button id="request_token_button" type="submit" class="btn btn-primary">Richiedi token</button>
                </form>
            </div>
            <div class="offset-1 col-10 my-3">
                <div class="collapse" id="loading-element">
                    <div class="card bg-info text-center">
                        <div id="card-loading" class="card-body">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset-1 col-10 my-3">
                <h5>Se già possiedi il token, inseriscilo nel campo sottostante</h5>
                <form action="#" method="POST" class="form-inline" id="activation_form">
                    @csrf
                    @method('PATCH')
                    <input id="token_code" type="text" class="form-control mr-2" id="token" placeholder="Token" required>
                    <button id="activate_token_button" type="submit" class="btn btn-success">Inizia a utilizzare l'app</button>
                </form>
            </div>
        </div>
    </div>
</div>