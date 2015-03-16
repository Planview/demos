@if (Session::has('message'))
    {{ Button::info(Session::get('message')) }}
@elseif (Session::has('error'))
    {{ Button::danger(Session::get('error')) }}
@endif
