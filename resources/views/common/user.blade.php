<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'greenhorn_works') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="{{ asset('css/navbar-fixed-left.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/clock.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top under-shadow">
    <div class="container">
      <div class="navbar-header">
        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>
      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Right Side Of Navbar -->
        <div class="nav navbar-nav navbar-right nav-user">
          <div class="dropdown">
            <a class="user-name-box dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <img src="{{ Auth::user()->avatar }}">&nbsp;&nbsp;&nbsp;{{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <nav class="navbar navbar-fixed-left">
    <div class="container">
      <div class="navbar-header navbar-left-header">MENU</div>
      <div class="navbar-collapse collapse">
        <ul class="nav-left-list">
          <li>
            <a href="{{ route('attendance.index') }}"><i class="fa fa-briefcase">勤怠</i></a>
          </li>
          <li>
            <a href="{{ route('report.index') }}"><i class="fa fa-pencil-square-o">日報</i></a>
          </li>
          <li>
            <a href="{{ route('question.index') }}"><i class="fa fa-comments-o">質問掲示板</i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- Scripts -->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
