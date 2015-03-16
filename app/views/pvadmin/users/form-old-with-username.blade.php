@extends("master.layout-admin")

@section("title")
    {{ $title }}
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <h1>{{ $title }}</h1>
    </header>
    <article>
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method]) }}
        <div class="col-sm-9">
            <fieldset>
                <legend>General Info</legend>
                @if (null === $user->id)
                    {{-- Test if we're creating a new user --}}
                    {{ ControlGroup::generate(
                        Form::label('username', 'Username'),
                        Form::text('username', Input::old('username'), ['required']) . $errors->first('username', '<span class="label label-danger">:message</span>'),
                        null,
                        3
                    ) }}
                @else
                    {{ ControlGroup::generate(
                        Form::label('username', 'Username'),
                        Form::text('username', $user->username, ['disabled']),
                        null,
                        3
                    ) }}
                @endif
                {{ ControlGroup::generate(
                    Form::label('email', 'Email'),
                    Form::email('email', Input::old('email') ?: $user->email, ['required']) . $errors->first('email', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('roles', 'Roles'),
                    Form::select('roles', $roles, Input::old('roles') ?: $user->rolesById(), ['multiple', 'name' => 'roles[]']),
                    null,
                    3
                ) }}
            </fieldset>
            <fieldset>
                <legend>ISR-Only Information</legend>
                {{ ControlGroup::generate(
                    Form::label('isr_first_name', 'ISR First Name'),
                    Form::text('isr_first_name', Input::old('isr_first_name') ?: $user->isr_first_name) . $errors->first('isr_first_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_last_name', 'ISR Last Name'),
                    Form::text('isr_last_name', Input::old('isr_last_name') ?: $user->isr_last_name) . $errors->first('isr_last_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_phone', 'ISR Phone'),
                    Form::text('isr_phone', Input::old('isr_phone') ?: $user->isr_phone) . $errors->first('isr_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_mobile_phone', 'ISR Mobile Phone'),
                    Form::text('isr_mobile_phone', Input::old('isr_mobile_phone') ?: $user->isr_mobile_phone) . $errors->first('isr_mobile_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_location', 'ISR Location'),
                    Form::text('isr_location', Input::old('isr_location') ?: $user->isr_location) . $errors->first('isr_location', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
            </fieldset>
            <fieldset>
                <legend>Authentication</legend>
                {{ ControlGroup::generate(
                    Form::label('password', 'New Password'),
                    Form::password('password') . $errors->first('password', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('password_confirmation', 'Confirm New Password'),
                    Form::password('password_confirmation') . $errors->first('password_confirmation', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                @if (null === $user->id)
                    {{ ControlGroup::generate(
                        Form::label('auto_confirm', 'Auto-confirm User'),
                        '<div class="checkbox"><label>' . Form::checkbox('auto_confirm', 1, Input::old('auto_confirm')) . ' Do not send confirmation</label></div>',
                        Form::help('Use this if the user should not receive a confirmation email'),
                        3
                    ) }}
                    {{ ControlGroup::generate(
                        Form::label('auto_password', 'Auto-generate Password'),
                        '<div class="checkbox"><label>' . Form::checkbox('auto_password', 1, Input::old('auto_password')) . ' Generate a password and email it to the user</label></div>',
                        Form::help('The user&rsquo;s account will be confirmed and the credentials will be sent to the user'),
                        3
                    ) }}

                @endif
            </fieldset>
        </div>
        <div class="col-sm-3">
            <div class="well">
                {{ Button::primary('Submit')->submit()->block() }}
            </div>
        </div>
    {{ Form::close() }}
    </article>
@stop
