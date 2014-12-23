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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"> -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
  <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
  <header id="site-header">
    <nav id="nav-menu-demos" class="menu-top">

    <ul>
      <li>{{HTML::link('/demos', 'Home', array('id' => 'topnav-home'));}}</li>
      <li>{{HTML::link('/demos', 'Demos', array('id' => 'topnav-demos'));}}</li>
      <li>{{HTML::link('/demos', 'Logout', array('id' => 'topnav-logout'));}}</li>

        <li>{{HTML::link('/pvadmin/demos', 'Admin', array('id' => 'topnav-admin'));}}
        <ul id="topnav-admin-dropdown">
        @section('nav_menu_admin')
          <li>{{HTML::link('/pvadmin/demos', 'View All Demos', array('id' => 'topnav-admin-demos'));}}</li>
          <li>{{HTML::link('/pvadmin/demos/create', 'Create a New Demo', array('id' => 'topnav-admin-create'));}}</li>  
        @show
        </ul>

      </li>     
    </ul>
    </nav>
  </header>
  <main id="content">
    <section id="page-body">

      @yield("page_messages",'')

      <header class="entry-header">
        <h1 class="entry-title">
          @yield("page_title")
        </h1>
      </header>

		  <div class="entry-content">
        @yield("page_content")
		  </div>

    </section>

  @section('footer_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script> -->
    <!-- individual page scripts -->
  @show
  </main>
  <footer id="site-footer">
    &copy; <?php echo date("Y"); ?> Planview, Inc., All Rights Reserved. 
  </footer>
  </body>
</html>