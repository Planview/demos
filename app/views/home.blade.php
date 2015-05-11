<?php
    $body_class = "home";
?>
@extends("master.layout")

@section("title")
    Planview Enterprise Product Demos
@stop

@section("content")
    <h1 id="page-title" class="sr-only">Planview Enterprise Product Demos</h1>
    @if (Auth::check())
    <div class="col-sm-4 col-sm-push-8">

        <div class="right-sidebar">
            @include('master.contact-module')
        </div>

    </div>
    @else
      {{ Form::open(['action' => 'UsersController@doLogin', 'class' => 'col-sm-4 col-sm-push-8']) }}
      <div class="panel panel-default panel-homepage-login">
        @if (Session::get('message'))
            <p class="error-message text-center">{{{ Session::get('message') }}}</p>
        @endif
        @if (Session::get('error'))
            <p class="error-message text-center">{{{ Session::get('error') }}}</p>
        @endif
        @if (Session::get('notice'))
            <p class="error-message text-center">{{{ Session::get('notice') }}}</p>
        @endif
        <div class="panel-heading hidden">
          <h4 class="panel-title">Login</h4>
        </div>
        <div class="panel-body">
          <div class="form-group"><label for="email" class="sr-only">Email</label><input type="text" class="form-control" name="email" id="email" placeholder="Email"></div>
          <div class="form-group"><label for="password" class="sr-only">Password</label><input type="password" class="form-control" name="password" id="password" placeholder="Password"></div>
          <div class="text-center">
            <button class="btn btn-success" type="submit">View Demos</button>
          </div>
        </div>
      </div>
      {{ Form::close() }}
    @endif
      <article class="col-sm-8 col-sm-pull-4 content">
        <h2>Get a Look Inside Planview Enterprise</h2>

        <p>See how Planview helps enterprises drive innovation, become more agile and efficient, and improve their business performance. As the market leader in portfolio management, Planview combines a passion for customer success with a commitment to innovation and thought leadership. Throughout the enterprise, Planview's customers use portfolio management to capitalize on business opportunities and thrive in a dynamic, global economy.</p>

        @if (Auth::check())
            {{ Button::success('Go to Product Demos')->asLinkTo(route('demos.index')) }}
        @else
            <p>Please email <a href="mailto:market@planview.com" title="Email market@planview.com">market@planview.com</a> to request access to Planview Enterprise product demos.</p>
        @endif
      </article>
@stop

@if (!Auth::check())
    @section('scripts')
        @parent
        {{-- This fixes the placeholder attribute in IE --}}
        {{-- http://jamesallardice.github.io/Placeholders.js/ --}}
        {{ HTML::script('/js/placeholders.min.js') }}
    @stop
@endif
