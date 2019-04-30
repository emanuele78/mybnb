<div class="custom_container">
    <div class="custom_container_header custom_full_border mt-2">
        <div class="header_image" style="background-image: url('{{asset('img/apartments/')}}/{{$apartment_image}}')"></div>
        <div class="header_content">
            @if($current_user_is_owner)
                <small class="card-text text-muted my-0">Conversazione per il tuo appartamento</small>
            @else
                <small class="card-text text-muted my-0">Conversazione per l'appartamento</small>
            @endif
            <a href="{{route('show',$apartment_slug)}}" id="current_apartment" data-apartment="{{$apartment_slug}}" data-thread="{{$thread_reference}}" class="card-text my-0">{{$apartment_title}}</a>
            @if($current_user_is_owner)
                <small class="card-text text-muted my-0">con l'utente</small>
                <p class="card-text my-0">{{$with_user}}</p>
            @else
                <small class="card-text text-muted my-0">proprietario</small>
                <p class="card-text my-0">{{$apartment_owner}}</p>
            @endif
            <div class="align-self-end">
                <button id="delete_button" class="btn btn-danger mt-2">Elimina conversazione</button>
                <a href="{{route('message_dashboard').'?show_by='.$show_by}}" id="back_button" class="btn btn-primary mt-2">Indietro</a>
            </div>
        </div>
    </div>
    <div class="custom_container_body custom_border"></div>
    <div class="custom_container_footer custom_full_border mb-2">
        @if($current_user_is_owner)
            <label for="body">Invia un messaggio a {{$with_user}}</label>
        @else
            <label for="body">Invia un messaggio a {{$apartment_owner}}</label>
        @endif
        <textarea class="form-control" id="body" rows="3" name="body" required placeholder="Scrivi il tuo messaggio"></textarea>
        <span class="invalid-feedback" role="alert"><strong>Il messaggio deve essere compreso tra 10 e 4000 caratteri</strong></span>
        <button id="submit_message" class="btn btn-primary pl-5 pr-5 align-self-start mt-2">Invia</button>
    </div>
</div>
@component('components.modal_action')
    @slot('modal_title','Conferma cancellazione')
    @slot('modal_dismiss_button_text','Annulla')
    @slot('modal_confirm_button_text','Cancella')
    Confermi la cancellazione di questa conversazione?
@endcomponent
<script id="message-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="message">
        <span class="font-weight-bold">@{{#senderName this.sender}}@{{/senderName}}</span>
        <small class="text-muted"> @{{this.sent_at}}</small>
        @{{#ifCond this}}
        @{{#if this.unread}}
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