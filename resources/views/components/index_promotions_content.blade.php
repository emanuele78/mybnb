<div class="container">
    <div class="promoted_apartments_section">
        <div class="title_section">
            <span class="main_title">Alloggi</span>
            <h2 class="sub_title">Scopri gli appartamenti in evidenza</h2>
        </div>
        <div class="cards_wrapper">
            @foreach($promotedApartments as $promotedApartment)
                <a href="{{route('show',$promotedApartment->slug)}}" class="apartment_wrapper {{$promotedApartment->activePromotionPlan()}}">
                    <div class="apartment_image" style="background-image: url('img/apartments/{{$promotedApartment->main_image}}')"></div>
                    <span class="apartment_description">
                        <div class="info">{{$promotedApartment->people_count}} PERSONE - {{$promotedApartment->room_count}} STANZE</div>
                        <div class="title">{{$promotedApartment->title}}</div>
                    </span>
                    <div class="grey_layer"></div>
                    <div class="layer_text">SCOPRI
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>