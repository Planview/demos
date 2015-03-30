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
        <h1>{{{$title}}}</h1>
    </header>
    <article>
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method])}}
        <div class="col-sm-9">
            {{ ControlGroup::generate(
                Form::label('name', 'Name'),
                Form::text('name', Input::old('name') ?: $role->name, ['required']) . $errors->first('name', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('permissions', 'Permissions'),
                Form::select('permissions', $permissions, Input::old('permissions') ?: $role->permissionsById(), ['multiple', 'name' => 'permissions[]']),
                null,
                3
            ) }}
        </div>
        <div class="col-sm-3">
            <div class="well">
                {{ Button::primary('Submit')->submit()->block() }}
            </div>
        </div>
    {{ Form::close() }}
    </article>
@stop
