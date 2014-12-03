@extends("master.layout")

@section("page_title")
	@if ($demo->deleted_at)
		EXPIRED: 
	@endif
	{{{$demo->title}}} - show
@stop

@section("nav_menu_admin")
	@parent
	| {{HTML::link('/pvadmin/demos/'.$demo->id.'/edit', 'edit this demo');}}
@stop

@section("page_messages")
	@if(isset($page_messages))
		<h2>{{{$page_messages}}}</h2>
	@endif
@stop

@section("page_content")
	<article><p>{{{$demo->description}}}</p></article>
@stop