<div class="custom_container">
    <div class="custom_container_header custom_full_border mt-2">
        <div class="header_image" style="background-image: url('{{asset('img/apartments/')}}/{{$apartment->main_image}}')"></div>
        <div class="header_content">
            <small class="card-text text-muted">Conversazione per il tuo appartamento</small>
            <p class="card-text mb-0">{{$apartment->title}}</p>
            <small class="card-text text-muted">con</small>
            <p class="card-text mb-0">{{$user->nickname}}</p>
            <button class="btn btn-danger mt-2 align-self-end">Elimina conversazione</button>
        </div>
    </div>
    <div class="custom_container_body custom_border">
        @foreach($thread as $message)
            <div class="message">
                <span class="font-weight-bold">{{$message->sender_id==$apartment->user->nickname?'Tu':$message->sender_id}}</span>
                <small class="text-muted"> {{$message->created_at}}</small>
                @if($message->sender_id==$apartment->user->nickname)
                    @if($message->unreaded)
                        <small class="text-muted">
                            <i class="far fa-check-circle"></i>
                        </small>
                    @else
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i>
                        </small>
                    @endif
                @endif
                <p>{{$message->body}}</p>
            </div>
        @endforeach
    </div>
    <div class="custom_container_footer custom_full_border mb-2">
        <label for="body">Invia un messaggio a {{$user->nickname}}</label>
        <textarea class="form-control" id="body" rows="3" name="body" required placeholder="Scrivi il tuo messaggio"></textarea>
        <span class="invalid-feedback" role="alert"><strong>Il messaggio deve essere compreso tra 10 e 4000 caratteri</strong></span>
        <button id="submit_message" class="btn btn-primary pl-5 pr-5 align-self-start mt-2">Invia</button>
    </div>
    {{--<input type="hidden" id="message_apartment_slug" value="{{$apartment->slug}}">--}}
    {{--<input type="hidden" id="message_sender_nickname" value="{{auth()->user()->nickname}}">--}}
    {{--<input type="hidden" id="message_recipient_nickname" value="{{$apartment->user->nickname}}">--}}
    {{--<div class="form-group">--}}
    {{--<label for="body">Invia un messaggio a {{$user->nickname}}</label>--}}
    {{--<textarea class="form-control" id="body" rows="6" name="body" required placeholder="Scrivi il tuo messaggio"></textarea>--}}
    {{--<span class="invalid-feedback" role="alert"><strong>Il messaggio deve essere compreso tra 10 e 4000 caratteri</strong></span>--}}
    {{--</div>--}}
    {{--<button id="submit_message" class="btn btn-primary pl-5 pr-5">Invia</button>--}}
</div>