<div class="container">
    <div class="promoted_apartments_section">
        <div class="title_section">
            <span class="main_title">Appartamenti</span>
            <h2 class="sub_title">Scopri gli appartamenti in evidenza</h2>
        </div>
        <div class="cards_wrapper">
            @foreach($promotedApartments as $promotedApartment)
                <a href="" class="apartment_wrapper {{$promotedApartment->promotions->first()->promotion_plan->card_type}}">
                    <div class="apartment_image" style="background-image: url('img/apartments/{{$promotedApartment->images()->first()->name}}')"></div>
                    <span class="apartment_description">
                        <div class="info">{{$promotedApartment->people_count}} PERSONE - {{$promotedApartment->room_count}} STANZE</div>
                        <div class="title">{{$promotedApartment->title}}</div>
                    </span>
                    <div class="grey_layer"></div>
                    <div class="layer_text">SCOPRI <i class="fas fa-arrow-right"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</div>