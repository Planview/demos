<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			@yield("page_title") | Planview Demos
		</title>
		<meta name="description" content="{{{ $meta_description or '' }}}" />
		<meta name="robots" content="{{{ $robots or 'noindex,nofollow' }}}" />
		@include('master.header')
	</head>
    <body>

    	<nav id="main-nav" class="menu">
    		{{HTML::link('/demos/?show=all', 'view all demos');}} | 
    		{{HTML::link('/demos/create', 'create a new demo');}}
    	</nav>

		<?php if($__env->yieldContent('page_breadcrumb')) { ?>
    		<p class="breadcrumb">&laquo; @yield('page_breadcrumb')</p>
		<?php } ?>

		<section id="page-body">

        <h1>
        	@yield("page_title")
        </h1>

		<main>
			@yield("page_content")
		</main>

		</section>

		@include('master.footer')
    </body>
</html>