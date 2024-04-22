@component('mail::message')
# ¡Gracias por tu interés en {{ config('app.name') }}!

Hola {{ $name }},

Muchas gracias por tu mensaje y tu interés en {{ config('app.name') }}.

@if ($user_message)
## Tu mensaje:

```
{{ $user_message }}
```
@endif

Nos pondremos en contacto contigo a la brevedad posible.

Si tienes cualquier otra duda o comentario adicional, simplemente responde a este correo.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
