<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <title>@yield("title") | Planview Product Demos</title>
    <meta name="description" content="">
    <meta name="robots" content="{{{ $robots or 'noindex,nofollow' }}}">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8; IE=EmulateIE9">
    @section('styles')
      {{ HTML::style('/css/main.min.css') }}
      {{ HTML::style('//fast.fonts.net/cssapi/2efe21fa-d468-4c24-a867-67a8c2fb7004.css') }}
      <!-- individual page styles -->
    @show
  </head>
  <body class="{{{ $body_class or '' }}}"> 
  <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>

  <div id="site-wrapper" class="container">
    <header id="site-header" class="row">
    <div id="left-gray-border" class="row">
      <div class="col-sm-5 col-md-4 col-lg-4">
        <div class="site-title">
          <h1>Planview Product Demos</h1>
        </div>
      </div>
      <div class="site-info col-sm-7 col-md-8 col-lg-8">
        <div class="row hidden-xs site-nav-top-padding">
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
                                <li>{{HTML::link('/pvadmin/users?allUsers=true', 'All Users', array('id' => 'topnav-admin-users-all'));}}</li>
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
                <li><a href="https://twitter.com/planview" title="Planview on Twitter" target="_blank"><span class="fa fa-twitter-square fa-lg"></span><span class="sr-only">Planview on Twitter</span></a></li>
                <li><a href="http://www.linkedin.com/company/planview" title="Planview on LinkedIn" target="_blank"><span class="fa fa-linkedin-square fa-lg"></span><span class="sr-only">Planview on LinkedIn</span></a></li>
                <li><a href="https://www.xing.com/companies/planviewgmbh-portfoliodrivenperformance" title="Planview auf XING" target="_blank"><span class="fa fa-xing-square fa-lg"></span><span class="sr-only">Planview auf XING</span></a></li>
                <li><a href="http://www.youtube.com/planviewvideos" title="Planview on YouTube" target="_blank"><span class="fa fa-youtube-square fa-lg"></span><span class="sr-only">Planview on YouTube</span></a></li>
                <li><a href="https://www.facebook.com/pages/Planview-Inc/89422974772" title="Planview on Facebook" target="_blank"><span class="fa fa-facebook-square fa-lg"></span><span class="sr-only">Planview on Facebook</span></a></li>
              </ul>
            </div>
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
      <div class="row footer-logo">
        <div class="site-title-footer-planview">
          <a href="http://www.planview.com/" title="Planview" target="_blank">
            <h1>Planview</h1>
          </a>
        </div>
      </div>
    <footer id="site-footer">
      &copy; <?php echo date("Y"); ?> Planview, Inc., All Rights Reserved. 
    </footer>
  </div>
    @section('scripts')
      {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
      {{ HTML::script('/js/bootstrap.min.js') }}
      {{-- SmartMenus jQuery plugin --}}
      <script src="/js/jquery.smartmenus.js"></script>
      {{-- SmartMenus jQuery Bootstrap Addon --}}
      <script src="/js/jquery.smartmenus.bootstrap.js"></script>
      {{-- Google Analytics --}}
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-16646450-15', 'auto');
        ga('send', 'pageview');
        ga('create', 'UA-16646450-1', 'auto', {'name': 'newTracker', 'allowLinker': true});
        ga('newTracker.require', 'linker'); 
        ga('newTracker.linker:autoLink', ['www.planview.com', 'www.planview.de', 'www.planview.fr'] ); 
        ga('newTracker.send', 'pageview');
      </script>
      <script src="/js/main.js"></script>
    @if (Auth::check())
        {{-- Marketo Munchkin Lead Tracking Code --}}
        <script src="http://munchkin.marketo.net/munchkin.js"></script>
        <script>
        Munchkin.init("587-QLI-337");
        Munchkin.munchkinFunction('associateLead',
            { Email: '{{ Auth::user()->email }}' },
            '{{ hash('sha1', 'Loc~*Gi4e!05EC3u~^d5m7L;1=.0;w' . Auth::user()->email) }}'
        );
        </script>
    @endif
      <!-- individual page scripts -->
    @show
  </body>
</html>
