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
      {{ HTML::style('/css/style.css') }}
      <!-- individual page styles -->
    @show
  </head>
  <body class="admin">
    @include('master.header-admin')
    <main id="page-body" class="container-fluid">
      @yield("page_messages",'')
      @yield('content')
    </main>
    @section('scripts')
      {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
      {{ HTML::script('/js/bootstrap.min.js') }}
      <!-- individual page scripts -->
    @show
    <footer id="site-footer">
      &copy; <?php echo date("Y"); ?> Planview, Inc., All Rights Reserved. 
    </footer>
  </body>
</html>
