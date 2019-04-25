<div class="custom_container">
    <div class="custom_container_header custom_full_border mt-2">
        <div class="header_image" style="background-image: url('{{asset('img/apartments/')}}/{{$apartment->main_image}}')"></div>
        <div class="header_content">
            <small class="card-text text-muted my-0">{{$title}}</small>
            <p id="current_apartment" data-apartment="{{$apartment->slug}}" class="card-text my-0">{{$apartment->title}}</p>
            <small class="card-text text-muted my-0">{{$with}}</small>
            <p id="other_user" data-other_user="{{$otherUser->nickname}}" class="card-text my-0">{{$otherUser->nickname}}</p>
            <div class="align-self-end">
                <button id="delete_button" class="btn btn-danger mt-2">Elimina conversazione</button>
                <a href="{{route('message_dashboard')}}" id="back_button" class="btn btn-primary mt-2">Indietro</a>
            </div>
        </div>
    </div>
    <div class="custom_container_body custom_border"></div>
    <div class="custom_container_footer custom_full_border mb-2">
        <input type="hidden" id="message_apartment_slug" value="{{$apartment->slug}}">
        <input type="hidden" id="message_sender_nickname" value="{{auth()->user()->nickname}}">
        <input type="hidden" id="message_recipient_nickname" value="{{$otherUser->nickname}}">
        <label for="body">Invia un messaggio a {{$otherUser->nickname}}</label>
        <textarea class="form-control" id="body" rows="3" name="body" required placeholder="Scrivi il tuo messaggio"></textarea>
        <span class="invalid-feedback" role="alert"><strong>Il messaggio deve essere compreso tra 10 e 4000 caratteri</strong></span>
        <button id="submit_message" class="btn btn-primary pl-5 pr-5 align-self-start mt-2">Invia</button>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancellazione</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">Confermi la cancellazione di questa conversazione?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" id="confirm_delete_button">Cancella</button>
            </div>
        </div>
    </div>
</div>
<script id="message-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="message">
        <span class="font-weight-bold">@{{#senderName this.sender_id}}@{{/senderName}}</span>
        <small class="text-muted"> @{{this.created_at}}</small>
        @{{#ifCond sender_id}}
        @{{#if this.unreaded}}
        <small class="text-muted">
            <i class="far fa-check-circle"></i>
        </small>
        @{{else}}
        <small class="text-success">
            <i class="fas fa-check-circle"></i>
        </small>
        @{{/if}}
        @{{/ifCond}}
        <p>@{{this.body}}</p>
    </div>
    @{{/each}}
</script>