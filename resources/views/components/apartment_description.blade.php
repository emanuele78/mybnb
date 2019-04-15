<div class="container my-3">
    <div class="row">
        <div class="card col-8">
            <div class="row no-gutters">
                <div class="col-4">
                    <img src="" class="card-img" alt="">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title">{{$apartment->title}}</h5>
                        <p class="card-text">
                            <small class="text-muted">Descrizione fornita dal proprietario, {{$apartment->user->nickname}}</small>
                        </p>
                        <p class="card-text">{{$apartment->description}}</p>
                        <p class="card-text">
                            <small class="text-muted">Ultimo aggiornamento il {{$apartment->updated_at}}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card offset-1 col-3">
            <div class="card-body">
                <h5 class="card-title">Verifica disponibilità</h5>
                <input type="text" class="form-control col-sm my-2 mr-2 flatpicker flatpickr-input" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly">
                <input type="text" class="form-control col-sm my-2 mr-2 flatpicker flatpickr-input" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly">
                <div class="">
                    <button class="btn btn-primary">Verifica</button>
                    <span>ok</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-3">
    <div class="row">
        <div class="card col-5">
            <div class="card-body">
                <h5 class="card-title">Servizi disponibili</h5>
                <ul>
                    @foreach($apartment->upgrades as $upgrade)
                        @if($upgrade->price_per_night==0)
                            <li>{{ucfirst($upgrade->service->name)}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card offset-2 col-5">
            <div class="card-body">
                <h5 class="card-title">Servizi con supplemento</h5>
                <ul>
                    @foreach($apartment->upgrades as $upgrade)
                        @if($upgrade->price_per_night>0)
                            <li>{{ucfirst($upgrade->service->name)}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @auth()
        @if(auth()->user()->id != $apartment->user->id)
            <div class="row my-3">
                <div class="card col">
                    <div class="card-body">
                        <div class="row">
                            <form class="col-12" action="" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Invia un messaggio al proprietario, {{$apartment->user->nickname}}</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Invia</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
    @guest()
        <div class="row my-3">
            Devi essere autenticato per inviare messaggi al proprietario
        </div>
    @endguest
</div>
