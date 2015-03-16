@extends("master.layout")

@section("title")
    Users by Company
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('users.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New User</a>
        <h1>Users by Company</h1>
    </header>
    {{ $users->links() }}
    <article>
        <ul>
            @forelse($users as $user)
                <li><strong>{{{ isset($user->company) ? $user->company . ': ' : '' }}}</strong><a href="{{ URL::route('users.show', ['id' => $user->id]) }}" title="Edit User">{{ $user->email }}</a>
                </li>
            @empty
                <li>What, no users?</li>
            @endforelse
        </ul>
    </article>
@stop
