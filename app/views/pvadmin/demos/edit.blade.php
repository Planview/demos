@extends("master.layout")

@section("page_title")
	Edit: 
	@if ($demo->deleted_at)
		EXPIRED: 
	@endif
	{{{$demo->title}}}
@stop

@section("nav_menu_admin")
	@parent
	| {{HTML::link('/pvadmin/demos/'.$demo->id, 'view this demo');}}
@stop

@section("page_content")
	<article>
	{{ Form::open(array('url' => '/pvadmin/demos/'.$demo->id, 'method' => 'PUT')); }}		
	{{ Form::label('demo_title', 'Demo Title: '); }}
	{{ Form::text('demo_title', $demo->title, array('id' => 'demo_title')); }}<br />
	{{ Form::label('demo_description', 'Demo Description: '); }}
	{{ Form::textarea('demo_description', $demo->description, array('id' => 'demo_description')); }}<br />
	{{ Form::submit('Update Demo', array('id' => 'submit_button_update', 'name' => 'submit_button_update')); }}
	{{ Form::close(); }}
	</article>
	<br />
	<article>
	@if ($demo->deleted_at)
		{{ Form::open(array('url' => '/pvadmin/demos/'.$demo->id, 'method' => 'PUT')); }}
		{{ Form::hidden('demo_title', $demo->title, array('id' => 'demo_title')); }}
		{{ Form::hidden('demo_description', $demo->description, array('id' => 'demo_description')); }}
		{{ Form::submit('Restore Expired Demo', array('id' => 'submit_button_restore', 'name' => 'submit_button_restore')); }}
		{{ Form::close(); }}
	@else
		{{ Form::open(array('url' => '/pvadmin/demos/'.$demo->id, 'method' => 'DELETE')); }}
		{{ Form::submit('Expire Demo', array('id' => 'submit_button_expire', 'name' => 'submit_button_expire')); }}
		{{ Form::close(); }}	
	@endif
	</article>
@stop