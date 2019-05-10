<div class="container mt-4">
    <h3 class="text-center">FAQ</h3>
    <div class="card mt-2">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#aim" aria-expanded="true">
                    Qual è lo scopo del progetto?
                </button>
            </h5>
        </div>
        <div id="aim" class="collapse show">
            <div class="card-body">
                <p>Il seguente progetto è stato creato unicamente ai fini di un portfolio personale.</p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#description" aria-expanded="true">
                    A cosa serve questo progetto?
                </button>
            </h5>
        </div>
        <div id="description" class="collapse show">
            <div class="card-body">
                <p>La presente demo emula una versione molto semplificata del sito AirBnB. Gli utenti una volta registrati possono effettuare delle prenotazioni sugli appartamenti inseriti nel sistema.</p>
                <p>Ogni utente a sua volta può registrare degli appartamenti, sponsorizzarli, ricevere e inviare messaggi in piattaforma.</p>
                <p>Sono presenti tre dashboard principali:</p>
                <ul>
                    <li><strong>Appartamenti</strong> - gestione degli appartamenti registrati nel sito. In questa dashboard è possibile inserire, modificare, cancellare e sponsorizzare i propri appartamenti.</li>
                    <li><strong>Prenotazioni</strong> - gestione delle prenotazioni fatte e ricevute. In questa dashboard gli utenti che hanno registrato appartamenti nel sito possono verificare le prenotazioni ricevute in modalità lista e calendario. E' inoltre possibile controllare le prenotazioni fatte presso altre strutture e scaricare la <strong>ricevuta in PDF</strong>.</li>
                    <li><strong>Messaggi</strong> - piattaforma dei messaggi. E' possibile controllare i messaggi ricevuti o inviati per un dato appartamento quindi accedere alla conversazione specifica.</li>
                </ul>
                <h5><u>Funzionalità specifiche</u></h5>
                <span class="text-muted"><strong>Appartamenti</strong></span>
                <p>Ogni appartamento possiede un'immagine principale, fino a un massimo di altre 4 immagini secondarie, un titolo rappresentativo, una descrizione e altre informazioni comuni. Il proprietario può scegliere di inserire una percentuale di sconto, una permanenza massima per ogni singola prenotazione e dei giorni nei quali si riserva di non accettare prenotazioni. Inoltre è possibile indicare dei servizi predefiniti o personalizzati. I servizi possono essere gratuiti o a pagamento. L'indirizzo dell'appartamento viene inserito tramite una casella di ricerca che sfrutta le <strong>API TomTom</strong> dalle quali si ottiene una lista di possibili risultati e la relativa mappa.</p>
                <span class="text-muted"><strong>Prenotazioni</strong></span>
                <p>E' possibile effettuare una prenotazione dalla pagina vetrina di ogni singolo appartamento dov'è verificabile anche la disponibilità per un dato periodo scelto dall'utente. Nell'atto della prenotazione l'utente può scegliere se e quali servizi a pagamento inserire per il soggiorno scelto. Il pagamento avviene mediante la piattaforma <strong>Braintree</strong>. Nel caso in cui il pagamento non venga effettuato, la prenotazione viene salvata nello stato in sospeso ed è richiamabile nella dashboard prenotazioni. Quando si avvia la procedura per una nuova prenotazione, l'appartamento in oggetto viene bloccato per il periodo scelto per un tempo definito nel sistema (attualmente impostato a {{config('project.pending_booking_max_life')}} minuti.</p>
                <span class="text-muted"><strong>Utenti</strong></span>
            </div>
        </div>
    </div>
</div>