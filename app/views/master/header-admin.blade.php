  <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
  <header id="site-header">
    <nav id="nav-menu-demos" class="menu-top">
      <ul>
        <li>{{HTML::link('/demos', 'Home', array('id' => 'topnav-home'));}}</li>
        <li>{{HTML::link('/demos', 'Demos', array('id' => 'topnav-demos'));}}</li>
        <li>{{HTML::link('/demos', 'Logout', array('id' => 'topnav-logout'));}}</li>
        <li>{{HTML::link('/users', 'Admin', array('id' => 'topnav-admin'));}}
          <ul id="topnav-admin-dropdown">
            @section('nav_menu_admin')
            <li>{{HTML::link('/pvadmin/demos', 'All Demos', array('id' => 'topnav-admin-demos'));}}</li>
            <li>{{HTML::link('/pvadmin/users', 'Admin Users', array('id' => 'topnav-admin-users'));}}</li>
            <li>{{HTML::link('/pvadmin/roles', 'Roles', array('id' => 'topnav-admin-roles'));}}</li>
            <li>{{HTML::link('/pvadmin/permissions', 'Permissions', array('id' => 'topnav-admin-permissions'));}}</li>
            @show
          </ul>
        </li>
      </ul>
    </nav>
  </header>
