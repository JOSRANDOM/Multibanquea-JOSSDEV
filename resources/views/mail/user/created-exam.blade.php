@component('mail::message')
# {{ $subject }}

Hola {{ $user->name }},

@if ($is_first_exam)
Felicitaciones por crear tu primer examen con {{ config('app.name') }}.

Aquí te explicamos cómo funcionan:

## ¿Qué es un examen?

Un examen es un conjunto de preguntas creado únicamente para ti, y que puedes responder para evaluar tu rendimiento.

Hay 3 tipos de exámenes:

* **Examen estándar**: Contiene preguntas al azar
* **Examen realista**: Contiene preguntas con una distribución realista, similar al examen real
* **Examen especializado**: Contiene preguntas de un área de estudios específica

Te recomendamos crear exámenes **estándar** cada vez que tengas tiempo libre, **especializados** cuando hayas identificado áreas para mejorar, y **realistas** cuando te sientas lista/o para simular un examen realista.

## ¿Como respondo un examen?

1. Ve a tu examen. Ahí encontrarás una lista de las preguntas.
2. Dale clic a **Responder** a la pregunta que quieras responder.
3. Elige una de las opciones y haz clic en **Confirmar respuesta**.
4. La siguiente pregunta aparecerá automáticamente.
5. Una vez termines de responder todas las preguntas, verás un resumen de tus respuestas. Siempre puedes cambiar cualquier respuesta.
6. Dale clic a **Calificar examen** para ver qué tan bien te fue.
@else
Tu examen ha sido creado.

Te deseamos mucho éxito respondiéndolo.
@endif

@component('mail::button', ['url' => route('exams.show', $exam), 'color' => 'red'])
Ir al examen
@endcomponent

Si tienes alguna pregunta, simplemente responde a este correo. Estaremos encantados de poder ayudarte en tu preparación para tu examen.

Gracias por usar nuestra plataforma,<br>
El equipo de {{ config('app.name') }}
@endcomponent
