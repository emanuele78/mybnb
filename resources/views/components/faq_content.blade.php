<div class="container mt-4">
    <h3 class="text-center">FAQ - TL;Dr</h3>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#aim" aria-expanded="true">
                    Qual è lo scopo del progetto?
                </button>
            </h5>
        </div>
        <div id="aim" class="collapse">
            <div class="card-body">
                <p>Il seguente progetto è stato creato unicamente ai fini di un portfolio personale.</p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#description" aria-expanded="true">
                    Come funziona questo progetto?
                </button>
            </h5>
        </div>
        <div id="description" class="collapse">
            <div class="card-body">
                <p>La presente demo emula una versione molto semplificata del sito AirBnB. Gli utenti una volta registrati possono effettuare delle prenotazioni sugli appartamenti inseriti nel sistema.</p>
                <p>Ogni utente a sua volta può registrare degli appartamenti, sponsorizzarli, ricevere e inviare messaggi in piattaforma.</p>
                <p>Sono presenti tre dashboard principali:</p>
                <ul>
                    <li>
                        <strong>Appartamenti</strong> - gestione degli appartamenti registrati nel sito. In questa dashboard è possibile inserire, modificare, cancellare e sponsorizzare i propri appartamenti.
                    </li>
                    <li>
                        <strong>Prenotazioni</strong> - gestione delle prenotazioni fatte e ricevute. In questa dashboard gli utenti che hanno registrato appartamenti nel sito possono verificare le prenotazioni ricevute in modalità lista e calendario. E' inoltre possibile controllare le prenotazioni fatte presso altre strutture e scaricare la
                        <strong>ricevuta in PDF</strong>.
                    </li>
                    <li>
                        <strong>Messaggi</strong> - piattaforma dei messaggi. E' possibile controllare i messaggi ricevuti o inviati per un dato appartamento quindi accedere alla conversazione specifica.
                    </li>
                </ul>
                <h5>
                    <u>Funzionalità specifiche</u>
                </h5>
                <span class="text-muted"><strong>Appartamenti</strong></span>
                <p>Ogni appartamento possiede un'immagine principale, fino a un massimo di altre 4 immagini secondarie, un titolo rappresentativo, una descrizione e altre informazioni comuni. Il proprietario può scegliere di inserire una percentuale di sconto, una permanenza massima per ogni singola prenotazione e dei giorni nei quali si riserva di non accettare prenotazioni. Inoltre è possibile indicare dei servizi predefiniti o personalizzati. I servizi possono essere gratuiti o a pagamento. L'indirizzo dell'appartamento viene inserito tramite una casella di ricerca che sfrutta le
                    <strong>API TomTom</strong> dalle quali si ottiene una lista di possibili risultati e la relativa mappa.
                </p>
                <span class="text-muted"><strong>Prenotazioni</strong></span>
                <p>E' possibile effettuare una prenotazione dalla pagina vetrina di ogni singolo appartamento dov'è verificabile anche la disponibilità per un dato periodo scelto dall'utente. Nell'atto della prenotazione l'utente può scegliere se e quali servizi a pagamento inserire per il soggiorno scelto. Il pagamento avviene mediante la piattaforma
                    <strong>Braintree</strong>. Nel caso in cui il pagamento non venga effettuato, la prenotazione viene salvata nello stato in sospeso ed è richiamabile nella dashboard prenotazioni. Quando si avvia la procedura per una nuova prenotazione, l'appartamento in oggetto viene bloccato per il periodo scelto per un tempo definito nel sistema (attualmente impostato a {{config('project.pending_booking_max_life')}} minuti.
                </p>
                <span class="text-muted"><strong>Utenti</strong></span>
                <p>Gli utenti guest possono effettuare ricerche, visitare la vetrina di ogni singolo appartamento e controllare disponibilità degli appartamenti. Con una prima regitrazione l'utente può inviare messaggi ai proprietari di appartamenti. Per effettuare prenotazioni, inserire propri appartamenti e promuoverli è richiesto un ulteriore step di registrazione che prevede l'inserimento dei dati per la fatturazione. Per identificare un utente viene usato un nickname. Gli utenti non possono conoscere il vero nome di altri utenti se non dopo aver concluso la prenotazione di un appartamento.</p>
                <span class="text-muted"><strong>Messaggi</strong></span>
                <p>I messaggi tra utenti vengono scambiati all'interno della piattaforma per mezzo dell'appartamento ovvero l'appartamento rappresenta il topic di un thread. Gli utenti interessati a un alloggio possono inviare messaggi al proprietario della struttura direttamente nella vetrina dell'appartamento. Una volta inviato un messaggio possono controllare eventuali risposte nell'area messaggi. Nuovi messaggi ricevuti vengono notificati nella navbar. Un thread è costituito quindi da due soli utenti, utente proprietario e utente interessato. All'interno del thread i messaggi vengono contrassegnati con delle spunte per indicare l'avvenuta lettura del messaggio.</p>
                <span class="text-muted"><strong>Pagamenti</strong></span>
                <p>I pagamenti sono simulati attraverso la
                    <strong>sandbox di Braintree</strong>. I pagamenti previsti riguardano la sponsorizzazione di un appartamento e la prenotazione presso di una struttura. Le ricevute in PDF delle sponsorizzazioni possono essere scaricate dal percorso Appartamenti / Promuovi / Mostra elenco promozioni. Le ricevute per le strutture prenotate sono disponibili al percorso Prenotazioni / Prenotazioni fatte / Mostra prenotazioni fatte.
                </p>
                <span class="text-muted"><strong>Promozioni</strong></span>
                <p>L'utente può secgliere di promuovere i propri appartamenti ponendoli in vetrina nella home page. Gli appartamenti in vetrina sono mostrati con delle card la cui grandezza dipende dal tipo di promozione attivata. Le promozioni attivabili al momento sono quattro: card piccola, card grande, card allungata in verticale e card allungata in orizzontale.</p>
                <span class="text-muted"><strong>Ricerche</strong></span>
                <p>La ricerca viene avviata dalla home page dov'è possibile selezionare una città italiana dall'elenco. Le date per il check-in e per il check-out sono facoltative. In alternativa è possibile cliccare sopra una delle venti card capoluogo per attivare la ricerca nella medesima città. Nella pagina dei risultati è possibile effettuare una ricerca avanzata inserendo ad esempio i servizi che deve possedere la struttura, allargare la ricerca per un dato raggio chilometrico dal luogo scelto, impostare una fascia di prezzo e altro ancora.</p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#visa" aria-expanded="true">
                    Quali carte di credito sono abilitate?
                </button>
            </h5>
        </div>
        <div id="visa" class="collapse">
            <div class="card-body">
                <p>Ai fini della presente demo, per effettuare prenotazioni e promozioni, è accettabile unicamente un carta di credito con codice
                    <strong>4111 1111 1111 1111</strong>. E' necessario inserire anche un data di scadenza valida (ovvero futura nel tempo), un codice di sicurezza e il CAP (entrambi a piacimento rispettando però la lunghezza mostrata dal segnaposto).
                </p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#apartments" aria-expanded="true">
                    Come vengono generati gli appartamenti presenti nel sistema?
                </button>
            </h5>
        </div>
        <div id="apartments" class="collapse">
            <div class="card-body">
                <p>Gli appartamenti sono generati attraverso un algoritmo che inserisce un appartamento per ogni principale città italiana ({{count(Config::get('cities'))}} in totale). Inoltre vengono generati ulteriori {{config('project.apartments_per_axys')}} appartamenti a Nord, Sud, Est e Ovest di ogni città a una distanza l'uno dall'altro pari a {{config('project.axys_distance_km')}} km. In totale
                    <strong>sono presenti {{(config('project.apartments_per_axys') * 4 + 1)*count(Config::get('cities'))}} appartamenti</strong>.
                </p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#data" aria-expanded="true">
                    Le modifiche apportate rimangono salvate nel sistema?
                </button>
            </h5>
        </div>
        <div id="data" class="collapse">
            <div class="card-body">
                <p>Eventuali modifiche come nuovi utenti creati, appartamenti inseriti, promozioni effettuate e altro, rimangono salvate per un periodo di tempo limitato. Con cadenza giornaliera il database ricreato da zero in modo da garantire la stessa esperienza d'uso a chinque volesse testare la presente demo.</p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true">
                    Esiste un utente demo?
                </button>
            </h5>
        </div>
        <div id="demo" class="collapse">
            <div class="card-body">
                <p>E' stato appositamente inserito un utente già configurato con il quale è possibile effettuare il login nel sito. Le credenziali d'accesso sono:</p>
                <ul>
                    <li>E-mail:
                        <strong>{{config('project.user_demo_email')}}</strong>
                    </li>
                    <li>Password:
                        <strong>{{config('project.user_demo_password')}}</strong>
                    </li>
                </ul>
                <p>E' comunque possibile creare nuovi utenti a proprio piacimento.</p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#source" aria-expanded="true">
                    Dove posso trovare il codice sorgente? Con quale licenza è distribuito?
                </button>
            </h5>
        </div>
        <div id="source" class="collapse">
            <div class="card-body">
                <p>Il codice sorgente del presente progetto è disponibile su
                    <a href="#">GitHub</a>
                </p>
                <p>La licenza applicata è la
                    <strong>licenza MIT</strong>:
                </p>
                <p>Copyright 2019{{\Carbon\Carbon::now()->year==2019?null:'-'.\Carbon\Carbon::now()->year}} Emanuele Mazzante
                <p>

                <pre>Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:</pre>

                <pre>The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.</pre>

                <pre>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.</pre>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h5 class="mb-0">
                <button class="btn text-primary" data-toggle="collapse" data-target="#info" aria-expanded="true">
                    Dove posso chiedere informazioni per questo progetto?
                </button>
            </h5>
        </div>
        <div id="info" class="collapse">
            <div class="card-body">
                <p>Puoi tranquillamente scrivermi a questo
                    <a href="mailto:ciao@emanuelemazzante.dev">indirizzo</a>
                </p>
            </div>
        </div>
    </div>
</div>