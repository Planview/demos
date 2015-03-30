@extends("master.layout")

@section("title")
    {{ $title }}
@stop

@section("styles")
    @parent
    <link type="text/css" href="/css/jquery-datepick.css" rel="stylesheet" />
    <style>
        button#generate_password { margin-right:1em; }
    </style>
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <h1>{{ $title }}</h1>
    </header>
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method]) }}
        <div class="col-sm-10">
            @if (null === $user->id)
                {{-- Test if we're creating a new user --}}
                {{ ControlGroup::generate(
                    Form::label('email', 'Email'),
                    Form::email('email', Input::old('email') ?: $user->email, ['required']) . $errors->first('email', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ Form::hidden('auto_password', 1) }}
            @else
                {{ ControlGroup::generate(
                    Form::label('email', 'Email'),
                    Form::email('email', Input::old('email') ?: $user->email, ['disabled']),
                    null,
                    3
                ) }}
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
            @endif
            {{ ControlGroup::generate(
                Form::label('company', 'Company'),
                Form::text('company', Input::old('company') ?: $user->company, ['required']) . $errors->first('company', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('expires', 'Expiration Date'),
                Form::text('expires', Input::old('expires') ?: $user->expires, ['required']) . $errors->first('expires', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('isr_contact_id', 'ISR'),
                Form::select('isr_contact_id', Input::old('isr_contact_id', $isrs), $user->isr_contact_id, ['required']) . $errors->first('isr_contact_id', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            <div class='form-group'>
            <label class="col-sm-3 control-label">
                Demo Access
            </label>
            <div class="col-sm-9">
                <?php 
                    $previous_language =  'none';
                    $previous_enterprise_version = 'none'; 
                ?>
                @forelse($demos as $demo)
                    @if (($demo->language != $previous_language) || ($demo->enterprise_version != $previous_enterprise_version))
                        {{ '<h3>'.$demo->language.' - PVE '.$demo->enterprise_version.'</h3>' }}
                    @endif
                    <?php 
                        in_array($demo->id, $user_demo_access) ? $checked = true : $checked = false;
                    ?>
                    {{ Form::checkbox('demo-access[]', $demo->id, $checked, array('class' => 'demo-access', 'id' => 'demo-'.$demo->id)) }} {{ Form::label('demo-'.$demo->id, $demo->title) }}<br />
                    <?php 
                        $previous_language =  $demo->language;
                        $previous_enterprise_version = $demo->enterprise_version; 
                    ?>
                @empty
                    <p>What, no demos?</p>
                @endforelse
            </div>
            </div>
            <div class='form-group'>
                <div class='col-sm-3'>&nbsp;</div>
                <div class='col-sm-4'>
                    <div class="well">
                        {{ Button::primary('Submit')->submit()->block() }}
                    </div>
                </div>
                <div class='col-sm-5'>&nbsp;</div>
            </div>
        </div>
    {{ Form::close() }}
    <div class="row">
        <div class="col-sm-6">
        <fieldset>
            <legend>Modify an Existing User</legend>
            {{ Form::horizontal(['route' => $action, 'method' => $method, 'class' => 'user-modify']) }}
            {{ ControlGroup::generate(
                Form::label('email-modify', 'Email'),
                Form::email('email-modify', '', ['required']) . $errors->first('email-modify', '<span class="label label-danger">:message</span>'),
                null,
                2
            ) }}
            <div class="row">
                <div class='col-sm-2'>
                </div>
                <div class='col-sm-6'>
                    <div class="well">
                        {{ Button::primary('Modify')->submit()->block() }}
                    </div>
                </div>
                <div class='col-sm-4'>
                </div>
            </div>
        {{ Form::close() }}
        </fieldset>
        </div>
        <div class="col-sm-6">
        <fieldset>
            <legend>View a User&rsquo;s History</legend>
            {{ Form::horizontal(['route' => $action, 'method' => $method, 'class' => 'user-history']) }}
            {{ ControlGroup::generate(
                Form::label('email-history', 'Email'),
                Form::email('email-history', '', ['required']) . $errors->first('email-history', '<span class="label label-danger">:message</span>'),
                null,
                2
            ) }}
            <div class="row">
                <div class='col-sm-2'>
                </div>
                <div class='col-sm-6'>
                    <div class="well">
                        {{ Button::primary('View')->submit()->block() }}
                    </div>
                </div>
                <div class='col-sm-4'>
                </div>
            </div>
        {{ Form::close() }}
        </fieldset>
        </div>
    </div>
@stop

@section("scripts")
    @parent
    <script src="/js/jquery-datepick.js"></script>
    <script>
        $(function() {
            $('#expires').datepick();
        });
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
