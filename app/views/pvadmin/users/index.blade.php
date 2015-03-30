<?php
    $body_class = "admin";
?>
@extends("master.layout")

@section("title")
    Manage Users
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('pvadmin.users.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New User</a>
        <h1>Manage Users</h1>
    </header>
    {{-- $users->links() --}}
    <article>
        <ul class="list-group">
            @forelse($users as $user)
                <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $user->email }}</h4>
                    {{ Button::primary('Edit')->asLinkTo(route('pvadmin.users.show', ['id' => $user->id])) }}
                    {{ Form::inline([
                        'route' => ['pvadmin.users.destroy', $user->id],
                        'class' => 'form-button form-button-delete',
                        'method'    => 'delete'
                    ]) }}
                        {{ Button::danger('Delete'); }}
                    {{ Form::close() }}
                </li>
            @empty
                <li>What, no users?</li>
            @endforelse
        </ul>

<br><br>USERS:
<?php
    var_dump($users);
?>

    </article>
@stop

@section("scripts")
    @parent
    @include('pvadmin.partials.button-delete-confirm-script')
@stop