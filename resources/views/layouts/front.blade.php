<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('layouts._head')
</head>

<body>
  <div id="app">
    <x-navbar />
    <main>
      @yield('content')
    </main>
    <x-footer />
  </div>
</body>

</html>
