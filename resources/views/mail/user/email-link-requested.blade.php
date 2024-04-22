@component('mail::message')
# Verifica tu correo electrónico

Hola,

Acabamos de recibir una solicitud para vincular la cuenta de <b>{{ $o_auth_user->name }}</b> en {{ config('app.name') }} con el correo electrónico <b>{{ $email }}</b>.

Si fuiste tú quien hizo esta solicitud, por favor confírmala dando clic en el siguiente botón. En caso contrario puedes ignorar este mensaje.

@component('mail::button', ['url' => route('register.linkEmail', [$o_auth_user, $o_auth_user->email_requested_response_token]), 'color' => 'primary'])
Verificar correo electrónico
@endcomponent

Si esta actividad te parece sospechosa o temes que tu cuenta esté comprometida, por favor comunícate con nosotros respondiendo a este correo.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
