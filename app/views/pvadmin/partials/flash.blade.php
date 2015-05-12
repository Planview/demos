@if (Session::has('message'))
    <div class="session-message">
        {{ Session::get('message') }}
    </div>
@elseif (Session::has('error'))
    {{ Button::danger(Session::get('error')) }}
@endif
