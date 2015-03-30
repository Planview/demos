<?php
    $body_class = "admin";
?>
@extends("master.layout")

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
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method])}}
        <div class="col-sm-9">
            <fieldset>
                <legend>Basic Info</legend>
                {{ ControlGroup::generate(
                    Form::label('name', 'Slug'),
                    Form::text('name', Input::old('name') ?: $permission->name, ['required']) . $errors->first('name', '<span class="label label-danger">:message</span>'),
                    Form::help('The slug should consist of only upper- and lowercase letters, numbers, and underscores'),
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('display_name', 'Display Name'),
                    Form::text('display_name', Input::old('display_name') ?: $permission->display_name, ['required']) . $errors->first('display_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
            </fieldset>
            <fieldset>
                <legend>Attached Roles</legend>
                {{ ControlGroup::generate(
                    Form::label('roles', 'Roles'),
                    Form::select('roles', $roles, Input::old('roles') ?: $permission->rolesById(), ['name' => 'roles[]', 'multiple']),
                    null,
                    3
                ) }}
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
