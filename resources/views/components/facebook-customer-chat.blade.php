<div id="fb-root"></div>
<script type="application/javascript">
    window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v10.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<div class="fb-customerchat" attribution="setup_tool" page_id="{{ config('services.facebook.page_id') }}" theme_color="{{ config('variant.colors.primary') }}" logged_in_greeting="¡Hola! ¿Cómo podemos ayudarte?" logged_out_greeting="¡Hola! ¿Cómo podemos ayudarte?" greeting_dialog_display="hide"></div>
