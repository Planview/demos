<?php
    $body_class = "admin";
?>
@extends("master.layout")

@section("title")
    {{{ $title }}}
@stop

@section("styles")
    @parent
    <style>
        button#generate_password { margin-right:1em; }
    </style>
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <h1>{{{ $title }}}</h1>
    </header>
    <article>
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method]) }}
        <div class="col-sm-9">
            <fieldset>
                <legend>General Info</legend>
                    @if (null === $user->id)
                    {{-- Test if we're creating a new user --}}
                        {{ ControlGroup::generate(
                            Form::label('email', 'Email'),
                            Form::email('email', Input::old('email') ?: $user->email, ['required']) . $errors->first('email', '<span class="label label-danger">:message</span>'),
                            null,
                            3
                        ) }}
                    @else
                        {{ ControlGroup::generate(
                            Form::label('email', 'Email'),
                            Form::email('email', Input::old('email') ?: $user->email, ['disabled']) . $errors->first('email', '<span class="label label-danger">:message</span>'),
                            null,
                            3
                        ) }}
                @endif
                {{ ControlGroup::generate(
                    Form::label('roles', 'Roles'),
                    Form::select('roles', $roles, Input::old('roles') ?: $user->rolesById(), ['multiple', 'name' => 'roles[]']),
                    null,
                    3
                ) }}
            </fieldset>
            <fieldset>
                <legend>ISR-Only Information</legend>
                {{-- ControlGroup::generate(
                    Form::label('isr_first_name', 'ISR First Name'),
                    Form::text('isr_first_name', Input::old('isr_first_name') ?: $isr->isr_first_name
                        ) . $errors->first('isr_first_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) --}}
                {{ ControlGroup::generate(
                    Form::label('isr_first_name', 'ISR First Name'),
                    Form::text('isr_first_name', Input::old('isr_first_name', $isr->isr_first_name
                        )) . $errors->first('isr_first_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_last_name', 'ISR Last Name'),
                    Form::text('isr_last_name', Input::old('isr_last_name', $isr->isr_last_name)) . $errors->first('isr_last_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_phone', 'ISR Phone'),
                    Form::text('isr_phone', Input::old('isr_phone', $isr->isr_phone)) . $errors->first('isr_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_mobile_phone', 'ISR Mobile Phone'),
                    Form::text('isr_mobile_phone', Input::old('isr_mobile_phone', $isr->isr_mobile_phone)) . $errors->first('isr_mobile_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_location', 'ISR Location'),
                    Form::text('isr_location', Input::old('isr_location', $isr->isr_location)) . $errors->first('isr_location', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
            </fieldset>
            @if (null === $user->id)
            {{-- Test if we're creating a new user --}}
                {{ Form::hidden('auto_password', 1) }}
            @else
                <fieldset>
                    <legend>Authentication</legend>
                    {{ ControlGroup::generate(
                        Form::label('password', 'New Password'),
                        Form::text('password') . $errors->first('password', '<span class="label label-danger">:message</span>'),
                        null,
                        3
                    ) }}
                    {{ ControlGroup::generate(
                        Form::label('password_confirmation', 'Confirm New Password'),
                        Form::password('password_confirmation') . $errors->first('password_confirmation', '<span class="label label-danger">:message</span>'),
                        null,
                        3
                    ) }}
                    {{ ControlGroup::generate(
                        Form::label('password_help', 'Generate Password'),
                        Button::success('Generate a New Password')->withAttributes(['id' =>'generate_password']),
                        Button::primary('Clear Password Field')->withAttributes(['id' =>'clear_password']),
                        3
                    ) }}
                </fieldset>
            @endif
        </div>
        <div class="col-sm-3">
            <div class="well">
                {{ Button::primary('Submit')->submit()->block() }}
            </div>
        </div>
    {{ Form::close() }}

<?php
    // echo "<br><br>ISR:";
    // var_dump($user->isrs());
    // echo "<br><br>USER:";
    // var_dump($user);
?>

    </article>
@stop

@section("scripts")
    @parent
    <script>
    $(document).ready(function(){ 
        $("#generate_password").click(function(){
            var the_password = generatePassword();
            $("#password").val(the_password);
            $("#password_confirmation").val(the_password);
            $(this).blur();
        });
        $("#clear_password").click(function(){
            $("#password").val('');
            $("#password_confirmation").val('');
            $(this).blur();
        });
    });
    function generatePassword() {
        var length = 8,
            charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }
    </script>
@stop
