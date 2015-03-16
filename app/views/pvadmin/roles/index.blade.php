@extends("master.layout-admin")

@section("title")
    Roles
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('pvadmin.roles.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New Role</a>
        <h1>Manage Roles</h1>
    </header>
    <article>
        <ul class="list-group">
            @forelse($roles as $role)
                <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $role->name }}</h4>
                    {{ Button::primary('Edit')->asLinkTo(route('pvadmin.roles.edit', ['id' => $role->id])) }}
                    {{ Form::inline([
                        'route' => ['pvadmin.roles.destroy', $role->id],
                        'class' => 'form-button form-button-delete',
                        'method'    => 'delete'
                    ]) }}
                        {{ Button::danger('Delete') }}
                    {{ Form::close() }}
                </li>
            @empty
                <li>What, no roles?</li>
            @endforelse
        </ul>
    </article>
@stop

@section("scripts")
    @parent
    @include('pvadmin.partials.button-delete-confirm-script')
@stop
