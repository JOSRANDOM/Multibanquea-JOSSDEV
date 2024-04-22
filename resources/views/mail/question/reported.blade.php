@component('mail::message')
# ¡Gracias por reportar una pregunta!

Hola {{ $user->name }},

Muchas gracias por tu reporte sobre la pregunta: **{{ $question->text }}** (#{{ $question->id }})

@if ($user_message)
## Tu mensaje:

```
{{ $user_message }}
```
@endif

Estamos muy enfocados en mejorar continuamente nuestra aplicación para brindarte la mejor herramienta de preparación para tu examen.

Revisaremos esta pregunta a la brevedad posible.

Si tienes cualquier duda o comentario adicional, simplemente responde a este correo.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
