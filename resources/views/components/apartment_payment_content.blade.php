<div class="container my-3">
    <div class="row">
        <div class="wrapper col">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <img src="{{asset('img/apartments')}}/{{$apartment->main_image}}" class="card-img" alt="">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 id="booking_ref" data-reference="{{$reference}}" class="card-title">Stai effettuando un pagamento per l'appartamento</h5>
                            <p class="card-text text-primary">{{$apartment->title}}</p>
                            <p class="card-text">
                                <small class="text-muted">Proprietario {{$apartment->owner()->nickname}}</small>
                            </p>
                            <h5 class="card-title">Per un totale di Euro <strong>{{number_format($bookingAmount,2,',','.')}}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>