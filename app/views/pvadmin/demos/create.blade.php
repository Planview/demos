@extends("master.layout")

@section("page_title")
	Create a New Demo
@stop

@section("page_content")
	<article>
	{{ Form::open(array('url' => '/pvadmin/demos', 'method' => 'POST')); }}		
	{{ Form::label('demo_title', 'Demo Title: '); }}
	{{ Form::text('demo_title', '', array('id' => 'demo_title')); }}<br />
	{{ Form::label('demo_description', 'Demo Description: '); }}
	{{ Form::textarea('demo_description', '', array('id' => 'demo_description')); }}<br />
	{{ Form::submit('Submit!', array('id' => 'submit_button')); }}
	{{ Form::close(); }}
	</article>
@stop