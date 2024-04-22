@component('mail::message')
# Tu pago en {{ config('app.name') }}

Hola {{ $user->name }},

Hemos recibido tu pago el {{ date('d/m/Y') }}:

**{{ $checkout_reference->plan->name }}:** S/ @formattedPrice($checkout_reference->amount_paid)


@if ($subscription)
Lo procesaremos a la brevedad posible para activar tu acceso a todas las funcionalidades de la plataforma, y te notificaremos por correo electrónico.

Si tu cuenta no ha sido activada en las siguientes 24 horas, o si tienes alguna pregunta adicional, por favor comunícate con nosotros respondiendo a este correo.
@else
Aún debes pagar **S/ @formattedPrice(($checkout_reference->total_price - $checkout_reference->amount_paid))**  para obtener acceso a todas las funcionalidades de la plataforma.

Si tienes alguna pregunta adicional, por favor comunícate con nosotros respondiendo a este correo.
@endif

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
