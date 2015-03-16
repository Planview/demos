@extends("master.layout")

@section("title")
	Planview Product Demos
@stop

@section("content")
	<article>
	@forelse($demos as $demo)
		@if (!$demo->deleted_at)
			<h2><a href="{{URL::route("demos.show", $demo->id)}}">{{{$demo->title}}}</a></h2><p>{{{$demo->description}}}</p>
		@endif
	@empty
		<p>What, no demos?</p>
	@endforelse
	</article>
	{{--$demos->links()--}}
@stop
