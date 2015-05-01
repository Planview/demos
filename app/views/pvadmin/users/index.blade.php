<?php
    $body_class = "admin";
?>
@extends("master.layout")

@section("title")
    {{{ $title }}}
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('pvadmin.users.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New User</a>
        <h1>{{{ $title }}}</h1>
    </header>
    <?php $allUsers = null; ?>
    @if ($links)
        {{ $users->appends(array('allUsers' => 'true'))->links() }}
    @endif
    <article>
        <ul class="list-group">
            @forelse($users as $user)
                <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $user->email }}</h4>
                    {{ Button::primary('Edit')->asLinkTo(route('pvadmin.users.show', ['id' => $user->id])) }}
                    @if ($links)
                        {{ Form::inline([
                            'route' => ['pvadmin.users.destroy', $user->id, 'allUsers' => 'true'],
                            'class' => 'form-button form-button-delete',
                            'method'    => 'delete'
                        ]) }}
                    @else
                        {{ Form::inline([
                                'route' => ['pvadmin.users.destroy', $user->id],
                                'class' => 'form-button form-button-delete',
                                'method'    => 'delete'
                            ]) }}
                    @endif
                        {{ Button::danger('Delete'); }}
                    {{ Form::close() }}
                </li>
            @empty
                <li>What, no users?</li>
            @endforelse
        </ul>
        @if ($links)
            {{ $users->appends(array('allUsers' => 'true'))->links() }}
        @endif
    </article>
@stop

@section("scripts")
    @parent
    @include('pvadmin.partials.button-delete-confirm-script')
@stop
