@component('mail::message')
# ¡Tu acceso a {{ config('app.name') }} ha sido activado!

Hola {{ $user->name }},

¡Felicitaciones! Has obtenido acceso a todas las funcionalidades de {{ config('app.name') }} desde el @formattedDate($subscription->starts_at) hasta el @formattedDate($subscription->ends_at).

Ahora podrás llevar tu preparación al siguiente nivel con el acceso a todas las funcionalidades de la plataforma, y obtendrás información personalizada sobre tu progreso.

Continúa con tu preparación:

@component('mail::button', ['url' => route('exams.create'), 'color' => 'primary'])
Ir a {{ config('app.name') }}
@endcomponent

Si tienes alguna pregunta adicional, por favor comunícate con nosotros respondiendo a este correo.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
