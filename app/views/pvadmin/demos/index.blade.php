@extends("master.layout-admin")

@section("title")
    Planview Product Demos
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <a href="{{ URL::route('pvadmin.demos.create') }}" class="btn btn-success pull-right"><span class="fa fa-plus"></span> Add New Demo</a>
        <h1>Manage Product Demos</h1>
    </header>
    <article>
        <ul class="list-group">
            @forelse($demos as $demo)
                @if (!$demo->deleted_at)
                    <li class="list-group-item">
                    <h4 class="list-group-item-heading">{{{$demo->title}}} <small>{{{$demo->language}}}, PVE {{{$demo->enterprise_version}}}</small></h4>
                        {{ Button::primary('Edit')->asLinkTo(route('pvadmin.demos.edit', ['id' => $demo->id])) }}
                        {{ Form::inline([
                            'route' => ['pvadmin.demos.destroy', $demo->id],
                            'class' => 'form-button form-button-delete',
                            'method'    => 'delete'
                        ]) }}
                            {{ Button::danger('Delete'); }}
                        {{ Form::close() }}
                    </li>
                @endif
            @empty
                <li>What, no demos?</li>
            @endforelse

            @forelse($demos as $demo)
                @if ($demo->deleted_at)
                    <li class="list-group-item">
                    <h4 class="list-group-item-heading">EXPIRED: {{{$demo->title}}} <small>{{{$demo->language}}}, PVE {{{$demo->enterprise_version}}}</small></h4>
                        {{ Button::primary('Edit')->asLinkTo(route('pvadmin.demos.edit', ['id' => $demo->id])) }}
                        {{ Form::inline([
                            'route' => ['pvadmin.demos.destroy', $demo->id],
                            'class' => 'form-button form-button-delete',
                            'method'    => 'delete'
                        ]) }}
                            {{ Button::danger('Delete'); }}
                        {{ Form::close() }}
                        {{ Form::inline([
                            'route' => ['pvadmin.demos.update', $demo->id],
                            'class' => 'form-button form-button-success',
                            'method'    => 'put'
                        ]) }}
                            {{ Form::hidden('submit_button_restore', 'restore'); }}
                            {{ Button::success('Restore')->addAttributes(array ('type' => 'submit')); }}
                        {{ Form::close() }}
                    </li>
                @endif
            @empty
                <li>What, no expired demos?</li>
            @endforelse
        </ul>
    </article>
@stop

@section("scripts")
    @parent
    @include('pvadmin.partials.button-delete-confirm-script')
@stop
