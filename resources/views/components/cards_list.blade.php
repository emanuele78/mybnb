<div class="container">
    <div class="cities_section">
        <div class="title_section">
            <span class="main_title">Città</span>
            <h2 class="sub_title">Scopri gli appartamenti nelle più belle città italiane</h2>
        </div>
        <div class="cards_wrapper">
            @foreach($majorCities as $majorCity)
                <a href="" class="city_wrapper {{$cardSizes[rand(0, count($cardSizes) - 1)]}}" style="background-image: url('../img/cities/{{addslashes($majorCity['name']).'.jpg'}}')">
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