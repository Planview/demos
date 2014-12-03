@extends("master.layout")

@section("page_title")
	Planview Product Demos
@stop

@section("page_content")
	<article>
	@forelse($demos as $demo)
		@if (!$demo->deleted_at)
			<h2><a href="{{URL::route("pvadmin.demos.show", $demo->id)}}">{{{$demo->title}}}</a></h2><p>{{{$demo->description}}}</p>
		@endif
	@empty
		<p>What, no demos?</p>
	@endforelse
	@foreach ($demos as $demo)
		@if ($demo->deleted_at)
			<h2><a href="{{URL::route("pvadmin.demos.show", $demo->id)}}">EXPIRED: {{{$demo->title}}}</a></h2><p>{{{$demo->description}}}</p>
		@endif
	@endforeach
	</article>
	{{--$demos->links()--}}
@stop

@section('footer_scripts')
    @parent
   <!-- individual page script -->
@stop