<?php
    $body_class = "admin";
?>
@extends("master.layout")

@section("title")
    Manage Permissions
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('pvadmin.permissions.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New Permission</a>
        <h1>Manage Permissions</h1>
    </header>
    <article>
        <ul class="list-group">
            @forelse($permissions as $permission)
                <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $permission->display_name }} <small>{{ $permission->name }}</small></h4>
                    {{ Button::primary('Edit')->asLinkTo(route('pvadmin.permissions.show', ['id' => $permission->id])) }}
                    {{ Form::inline([
                        'route' => ['pvadmin.permissions.destroy', $permission->id],
                        'class' => 'form-button form-button-delete',
                        'method'    => 'delete'
                    ]) }}
                        {{ Button::danger('Delete'); }}
                    {{ Form::close() }}
                </li>
            @empty
                <li>What, no permissions?</li>
            @endforelse
        </ul>
    </article>
@stop

@section("scripts")
    @parent
    @include('pvadmin.partials.button-delete-confirm-script')
@stop
