<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-soft">

<head>
  @include('layouts._head')
</head>

<body>
  <div id="@yield('main_id', 'app')">
    <x-header-app />
    <div class="container-fluid">
      <div class="row">
        {{-- <x-navbar-app /> --}}
        <x-navbar-app-new />
        <div class="app-main px-3 px-xl-5">
          <main class="@yield('main-class', 'app-main-container')">
            @yield('content')
          </main>
          <div class="mx-n3 mx-xl-n5">
            <x-footer />
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
@yield('inline_scripts')
