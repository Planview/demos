@extends("master.layout")

@section("page_title")
	{{{$demo->title}}}
@stop

@section("nav_menu_admin")
	@parent
	<li>{{HTML::link('/pvadmin/demos/'.$demo->id.'/edit', 'Edit This Demo', array('id' => 'topnav-admin-view'));}}</li>
@stop

@section("page_content")
	<article><p>{{{$demo->description}}}</p></article>
@stop