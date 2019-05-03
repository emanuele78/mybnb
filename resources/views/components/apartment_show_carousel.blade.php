<div class="container my-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div id="apartment_carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($images as $image)
                            <li data-target="#apartment_carousel" data-slide-to="{{$loop->index}}" {{$loop->first?'class="active"':''}}></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($images as $image)
                            <div class="carousel-item {{$loop->first?'active':''}} apartment_item">
                                <div class="apartment_image d-block w-100" style="background-image: url('{{asset('img/apartments/').'/'.$image}}')"></div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#apartment_carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#apartment_carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

