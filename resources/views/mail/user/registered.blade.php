@component('mail::message')
# ¡Bienvenida/o a {{ config('app.name') }}!

Hola {{ $user->name }},

¡Gracias por registrarte en {{ config('app.name') }}! Estamos muy contentos de poder acompañarte en tu camino de preparación para el examen.

Desde este momento puedes empezar a probar las funcionalidades de nuestra plataforma:

@component('mail::button', ['url' => route('exams.create'), 'color' => 'primary'])
Iniciar un examen
@endcomponent

Cuando quieras llevar tu preparación al siguiente nivel, puedes obtener acceso a todas las funcionalidades de {{ config('app.name') }}:

@component('mail::button', ['url' => route('subscriptions.index'), 'color' => 'red'])
Ver opciones de compra
@endcomponent

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
