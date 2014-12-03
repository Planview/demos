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
    <!-- Bootstrap -->
    <!-- <link href="/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>

  <nav id="nav-menu-demos" class="menu-top">
      {{HTML::link('/demos', 'back to demos');}}
  </nav>

  <nav id="nav-menu-admin" class="menu-top">
    @section('nav_menu_admin')
   		{{HTML::link('/pvadmin/demos', 'view all demos');}} | 
   		{{HTML::link('/pvadmin/demos/create', 'create a new demo');}}
    @show
  </nav>

	<section id="page-body">

        @yield("page_messages",'')

        <h1>
        	@yield("page_title")
        </h1>

		<main>
			@yield("page_content")
		</main>

	</section>

@section('footer_scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <!-- <script src="/js/bootstrap.min.js"></script> -->
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <!-- individual page scripts -->
@show
  </body>
</html>