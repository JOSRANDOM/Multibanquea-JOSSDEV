@component('mail::message')
# Tu correo electrónico ha sido verificado

Hola {{ $o_auth_user->name }},

Muchas gracias por verificar tu correo electrónico. <b>{{ $o_auth_user->email }}</b> acaba de ser vinculado exitosamente a tu cuenta de {{ config('app.name') }}.

Si esta actividad te parece sospechosa o temes que tu cuenta esté comprometida, por favor comunícate con nosotros respondiendo a este correo.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
