@extends("master.layout")

@section("page_title")
	{{{$demo->title}}}
@stop

@section("page_breadcrumb")
	{{HTML::link('/demos', 'back to product demos');}} | {{HTML::link('/demos/'.$demo->id.'/edit', 'edit this demo');}} &raquo;
@stop

@section("page_content")
	<article><p>{{{$demo->description}}}</p></article>
@stop