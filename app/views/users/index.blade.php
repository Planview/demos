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
    {{-- $users->links() --}}
    <article>
        <h2>Key</h2>
        <ul>
            <li><strong>Company:</strong> <a href="/users" title="Edit User">email address</a> <small>(expiration date)</small>
                </li>
        </ul>
        <h2>Users <small>(Click on an email to edit)</small></h2>
        <ul>
            @forelse($users as $user)
                <li><strong>{{{ isset($user->company) ? $user->company . ': ' : '' }}}</strong><a href="{{ URL::route('users.show', ['id' => $user->id]) }}" title="Edit User">{{ $user->email }}</a> <small>{{{ isset($user->expires) ? '('.$user->expires . ')' : '' }}}</small>
                </li>
            @empty
                <li>What, no users?</li>
            @endforelse
        </ul>
    </article>
@stop
