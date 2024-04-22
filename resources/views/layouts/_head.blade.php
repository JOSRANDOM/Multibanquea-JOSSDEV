<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="@yield('head.description')">
<meta name="robots" content="@yield('head.robots', 'index, follow')">

<title>@yield('head.title', config('app.name'))</title>

<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/brand/' . config('variant.name') . '/icon-120.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/brand/' . config('variant.name') . '/icon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/brand/' . config('variant.name') . '/icon-16.png') }}">
<meta name="msapplication-TileColor" content="{{ config('variant.colors.primary') }}">
<meta name="theme-color" content="{{ config('variant.colors.primary') }}">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
@yield('inline_css')
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">

<script src="{{ mix('/js/app.js') }}" defer></script>
<script src="{{ mix('/js/chart.js') }}" defer></script>
{{-- <script src="https://kit.fontawesome.com/a8c6d8db0b.js" crossorigin="anonymous"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

@yield('page-script')

{{-- Open Graph --------------------------------------------------------------}}
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('head.title', '{{ config("app.name") }} - Te ayudamos a prepararte para tu examen')">
<meta property="og:description" content="@yield('head.description', 'Plataforma moderna especializada en la preparación con bancos de preguntas.')">
<meta property="og:image" content="@yield('head.og-image', '')">

{{-- Twitter Meta Tags -------------------------------------------------------}}
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="{{ config('app.url') }}">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="@yield('head.title', '{{ config("app.name") }} - Te ayudamos a prepararte para tu examen')">
<meta name="twitter:description" content="@yield('head.description', 'Plataforma moderna especializada en la preparación con bancos de preguntas.')">
<meta name="twitter:image" content="@yield('head.og-image', '')">

{{-- Youtube Embed Videos -------------------------------------------------------}}
<x-embed-styles />

@if (App::environment() === 'production')
{{-- Global site tag (gtag.js) - Google Analytics ----------------------------}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('google-analytics.id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', '{{ config("google-analytics.id") }}');
</script>

{{-- Facebook Pixel ----------------------------------------------------------}}
<script>
  var visitorEmail = "@auth{{ Auth::user()->email }}@endauth"
  var visitor = {};
  if (visitorEmail) {
    visitor = {
      em: visitorEmail
    }
  }

  ! function(f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function() {
      n.callMethod ?
        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
  }(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '220037699835350', visitor);
  fbq('track', 'PageView');
</script>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=220037699835350&ev=PageView&noscript=1" /></noscript>
@endif
