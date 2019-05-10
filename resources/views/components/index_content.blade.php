<div class="container-fluid main_hero">
    <div class="container search_container">
        <div class="card search_form  offset-1 col">
            <div class="card-body">
                <form action="{{route('search')}}" class="form" method="get">
                    <div class="form-row">
                        <div class="col-md-3    ">
                            <select id="city" name="city_code" class="form-control my-2 mr-2">
                                @foreach($citiesList as $city)
                                    <option value="{{$city['code']}}">{{$city['name']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleziona una città dalla lista
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control my-2 mr-2 flatpicker flatpickr-input {{$errors->has('check_in')?'is-invalid':null}}" id="check_in" placeholder="Check-in" name="check_in" readonly="readonly" value="{{old('check_in')?:null}}">
                            <div class="invalid-feedback">
                                Controlla la data del check-in
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control my-2 mr-2 flatpicker flatpickr-input {{$errors->has('check_out')?'is-invalid':null}}" id="check_out" placeholder="Check-out" name="check_out" readonly="readonly" value="{{old('check_out')?:null}}">
                            <div class="invalid-feedback">
                                Controlla la data del check-out
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100 my-2 ">Cerca</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="promoted_apartments_section">
        <div class="title_section">
            <span class="main_title">Alloggi</span>
            <h2 class="sub_title">Scopri gli appartamenti in evidenza</h2>
        </div>
        <div class="cards_wrapper">
            @foreach($promotedApartments as $promotedApartment)
                <a href="{{route('show',$promotedApartment['slug'])}}" class="apartment_wrapper {{$promotedApartment['card_type']}}">
                    <div class="apartment_image" style="background-image: url('img/apartments/{{$promotedApartment['main_image']}}')"></div>
                    <span class="apartment_description">
                        <span class="info">{{$promotedApartment['people_count']}} PERSONE - {{$promotedApartment['room_count']}} STANZE</span>
                        <span class="title">{{$promotedApartment['title']}}</span>
                    </span>
                    <div class="grey_layer"></div>
                    <div class="layer_text">SCOPRI
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="cities_section">
        <div class="title_section">
            <span class="main_title">Città</span>
            <h2 class="sub_title">Scopri gli appartamenti nelle più belle città italiane</h2>
        </div>
        <div class="cards_wrapper">
            @foreach($majorCities as $majorCity)
                <a href="{{route('search').'?city_code='.$majorCity['code'].'&check_in=&check_out='}}" class="city_wrapper {{$citiesCardSizes[rand(0, count($citiesCardSizes) - 1)]}}" style="background-image: url('img/cities/{{addslashes($majorCity['name']).'.jpg'}}')">
                    <span class="city_name">{{ucwords($majorCity['name'])}}</span>
                    <div class="grey_layer"></div>
                    <div class="arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>