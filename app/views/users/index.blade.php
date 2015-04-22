@extends("master.layout")

@section("title")
    Manage Users (Listed by Company)
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('users.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New User</a>
        <h1>Manage Users <small>(Listed by Company)</small></h1>
    </header>
    <article>
        {{ $users->links() }}
        <div class="row">
            <div class="col-sm-12">
            <h2 style="margin-top:0;margin-right:0.5em;display:inline;">Key:</h2> <strong>Company:</strong> <a href="/users" title="Edit User">email address (click to edit)</a> <small>(expiration date)</small>
            </div>
        </div>
        <h2>Users <small>(Click on an email address to edit)</small></h2>
        <ul>
            @forelse($users as $user)
                <li><strong>{{{ isset($user->company) ? $user->company . ': ' : '' }}}</strong><a href="{{ URL::route('users.show', ['id' => $user->id]) }}" title="Edit User">{{ $user->email }}</a> <small>{{{ isset($user->expires) ? '('.$user->expires . ')' : '' }}}</small>
                </li>
            @empty
                <li>What, no users?</li>
            @endforelse
        </ul>
        {{ $users->links() }}
    </article>
@stop
