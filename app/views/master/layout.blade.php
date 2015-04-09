<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <title>@yield("title") | Planview Demos</title>
    <meta name="description" content="">
    <meta name="robots" content="{{{ $robots or 'noindex,nofollow' }}}">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8; IE=EmulateIE9">
    @section('styles')
      {{ HTML::style('/css/bootstrap.min.css') }}
      {{ HTML::style('//fast.fonts.net/cssapi/2efe21fa-d468-4c24-a867-67a8c2fb7004.css') }}
      <!-- individual page styles -->
    @show
  </head>
  <body class="{{{ $body_class or '' }}}"> 
  <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>

  <div id="site-wrapper" class="container">
    <header id="site-header" class="row">
      <div class="col-sm-5 col-md-4 col-lg-4">
        <div class="site-title">
          <h1>Planview Enterprise Product Demos</h1>
        </div>
      </div>
      <div class="site-info col-sm-7 col-md-8 col-lg-8">
        <div class="row hidden-xs">
          <a href="http://www.planview.com/" title="Planview" target="_blank">
            <div class="site-title-planview pull-right">
              <h1>Planview</h1>
            </div>
          </a>
        </div>
        <div class="row">
          <nav class="site-nav col-sm-8 col-md-8 col-lg-8"> 
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="/" id="topnav-home" class="navbar-nav-link-top">Home</a></li>
                <li><a href="/demos" id="topnav-demos" class="navbar-nav-link-top">Demos</a></li>
                @if (Auth::check())
                    <li><a href="/logout" id="topnav-logout" class="navbar-nav-link-top">Logout</a></li>
                    @if (Auth::user()->can('manage_isrs'))
                        <li><a href="/users" id="topnav-admin" class="navbar-nav-link-top">Admin</a>
                        <ul class="dropdown-menu">
                            @section('nav_menu_admin')
                                <li>{{HTML::link('/pvadmin/users', 'Admin Users', array('id' => 'topnav-admin-users'));}}</li>
                                <li>{{HTML::link('/pvadmin/users?allUsers=true', 'All Users', array('id' => 'topnav-admin-users'));}}</li>
                                @if (Auth::user()->can('manage_admins'))
                                    <li>{{HTML::link('/pvadmin/demos', 'All Demos', array('id' => 'topnav-admin-demos'));}}</li>
                                    <li>{{HTML::link('/pvadmin/roles', 'Roles', array('id' => 'topnav-admin-roles'));}}</li>
                                    <li>{{HTML::link('/pvadmin/permissions', 'Permissions', array('id' => 'topnav-admin-permissions'));}}</li>
                                @endif
                            @show
                        </ul>
                        </li>
                    @elseif (Auth::user()->can('manage_clients'))
                            <li><a href="/users" id="topnav-admin">Admin</a></li>
                    @endif
                @endif
              </ul>
            </div>
          </nav>
          <div class="col-sm-4 col-md-4 col-lg-4 hidden-xs hidden-sm">
            <div class="follow-links">
              <ul class="list-inline">
                <li><a href="https://twitter.com/planview" target="_blank" id="icon-social-twitter-link"><img src="/img/icon-social-twitter-23x23.png" width="23" height="23" alt="Planview on Twitter" title="Planview on Twitter" /></a></li>
                <li><a href="http://www.linkedin.com/company/planview" target="_blank"><img src="/img/icon-social-linked-in-23x23.png" width="23" height="23" alt="Planview on LinkedIn" title="Planview on LinkedIn" /></a></li>
                <li><a href="https://www.xing.com/companies/planviewgmbh-portfoliodrivenperformance" target="_blank"><img src="/img/icon-social-xing-23x23.png" width="23" height="23" alt="Planview auf XING" title="Planview auf XING" /></a></li>
                <li><a href="http://www.youtube.com/planviewvideos" target="_blank"><img src="/img/icon-social-youtube-23x23.png" width="23" height="23" alt="Planview on YouTube" title="Planview on YouTube" /></a></li>
                <li><a href="https://www.facebook.com/pages/Planview-Inc/89422974772" target="_blank"><img src="/img/icon-social-facebook-23x23.png" width="23" height="23" alt="Planview on Facebook" title="Planview on Facebook" /></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div id="content-topper"></div>
    <main class="row" id="content">
      @yield("page_messages",'')
      @yield('content')
    </main>
    <footer id="site-footer">
      &copy; <?php echo date("Y"); ?> Planview, Inc., All Rights Reserved. 
    </footer>
  </div>
    @section('scripts')
      {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
      {{ HTML::script('/js/bootstrap.min.js') }}

    <!-- SmartMenus jQuery plugin -->
    <script src="/js/jquery.smartmenus.js"></script>
    <!-- SmartMenus jQuery Bootstrap Addon -->
    <script src="/js/jquery.smartmenus.bootstrap.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <script src="/js/main.js"></script>

      <!-- individual page scripts -->
    @show

  </body>
</html>
