<?php
    $body_class = "demos";
?>
@extends("master.layout")

@section("title")
    Planview Product Demos
@stop

@section("content")
    <h1 id="page-title">View Planview Demos</h1>

    @if (Auth::check())
        <p class="demo-list-instructions">Click on a demo title to access:</p>

        <div class="right-sidebar">
            <div class="module-contact-info">
                <h2 id="header-contact">Contact</h2>
                <p><strong>ISR&nbsp;Admin</strong><br />
                Location: North America<br />
                Tel: 512-555-1212<br />
                Mobil: 512-555-1212<br />
                Email: <a href="mailto:isr-admin@planview.com" title="Email ISR&nbsp;Admin">isr-admin@planview.com</a></p>
            </div>
        </div>

        <ul class="product-demo-list">
            @forelse($demos as $demo)
                @if (!$demo->deleted_at)
                    <li><a href="{{URL::route("demos.show", $demo->id)}}">{{{$demo->title}}}</a><br /><div class="demo-description">{{$demo->description}}</div></li>
                @endif
            @empty
                <li>What, no demos?</li>
            @endforelse
        </ul>
        {{--$demos->links()--}}
    @else
        <p class="demo-list-instructions">Please email <a href="mailto:market@planview.com" title="Email market@planview.com">market@planview.com</a> to request access to Planview Enterprise product demos.</p>
        <div style="height:400px;"></div>
    @endif
@stop
