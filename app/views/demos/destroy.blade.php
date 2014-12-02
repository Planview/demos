@extends("master.layout")

@section("page_title")
	{{{$demo->title}}}
@stop

@section("page_breadcrumb")
	{{HTML::link('/demos', 'back to product demos');}}
@stop

@section("page_content")
	<article><p>The demo was expired.</p></article>
@stop