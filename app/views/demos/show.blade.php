@extends("master.layout")

@section("title")
    {{{$demo->title}}}
@stop

@section("nav_menu_admin")
    @parent
    <li>{{HTML::link('/pvadmin/demos/'.$demo->id.'/edit', 'Edit This Demo', array('id' => 'topnav-admin-view'));}}</li>
@stop

@section("content")
    <header class="page-header">
        <h1>{{{$demo->title}}}</h1>
    </header>
    <article><h2>Description</h2>{{{$demo->description}}}</article>
    <article><h2>Demo Code</h2>{{{$demo->demo_code}}}</article>
    <article><h2>Related Content Code</h2>{{{$demo->related_content_code}}}</article>
@stop
