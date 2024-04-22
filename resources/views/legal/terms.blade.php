@extends('layouts.front')

@section('content')
<main class="py-5 bg-light">
  <div class="container">
    <div class="row">
      <h1 class="mb-4">Aviso legal y condiciones generales de uso del sitio web {{ config('app.name') }}</h1>

      <div class="card card-body mb-7">
        <h2>Términos y condiciones</h2>
        <p>Última actualización: 09/02/2021</p>

        <h3>1. Definiciones</h3>
        <p><i>Acceder</i>: una o más acciones del Usuario necesarias: tratándose del Sitio, para el Acceso del Sitio; o, tratándose de un Sitio de Tercero, para abrir conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) una o más conexiones HTTP o HTTPS, respectivamente, entre la dirección de Internet de dicho Sitio de Tercero y la dirección de Internet de un dispositivo utilizado por el Usuario para abrir cada dicha conexión.</p>
        <p><i>Acceso del Sitio</i>: la apertura conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) de una o más conexiones HTTP o HTTPS, respectivamente, entre la dirección de Internet del Sitio y la dirección de Internet de un dispositivo utilizado por el Usuario para abrir cada dicha conexión.</p>
        <p><i>Actividad en el Sitio</i>: la utilización por el Usuario de una o más funcionalidades incluidas y habilitadas en el Sitio.</p>
        <p><i>Administrador</i>: la siguiente persona jurídica: Benlos S.A.C., con domicilio en la Avenida 28 De Julio 559, Miraflores, Lima, Perú, y con correo electrónico en {{ env('MAIL_ADDRESS_CONTACT') }}.</p>
        <p><i>Autoridad Pública</i>: cualquier órgano legislativo, ejecutivo o judicial de carácter nacional, regional, departamental, provincial o municipal.</p>
        <p><i>Cookie</i>: cada archivo digital que cumple los siguientes requisitos: (1) es creado por un sitio de Internet accedido por el Usuario por primera vez; (2) almacena uno o más datos sobre el Usuario (por ej., su identificación de acceso) y/o la actividad del Usuario en dicho sitio de Internet (por ej., las selecciones realizadas) con la finalidad de facilitar al Usuario el acceso a dicho sitio de Internet y la actividad en el mismo al menos por segunda vez; (3) es almacenado por el navegador web que el Usuario utilizó para acceder a dicho sitio de Internet por primera vez; y (4) puede ser leído solamente o leído y modificado por dicho sitio de Internet si el Usuario vuelve a acceder a dicho sitio de Internet utilizando el mismo navegador web al menos por segunda vez.</p>
        <p><i>Credencial de Seguridad</i>: uno o más datos personales y/u otros datos u otra información suministrados por una persona humana, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, para otorgar a dicha persona humana una identidad única e inequívoca como Usuario.</p>
        <p><i>Permanecer en el Sitio</i>: una o más acciones del Usuario, en el Sitio y conforme a los TyC, necesarias para prolongar la Permanencia en el Sitio.</p>
        <p><i>Permanencia en el Sitio</i>: el tiempo que transcurriere desde, e incluyendo, el Acceso del Sitio hasta, e incluyendo, la Salida del Sitio.</p>
        <p><i>Propietario</i>: el Administrador.</p>
        <p><i>Salida del Sitio</i>: el cierre conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) de la única o la última, según el caso, conexión HTTP o HTTPS, respectivamente, abierta por el Acceso del Sitio.</p>
        <p><i>Sitio</i>: cada archivo digital vacío o conteniendo uno o más textos (originales o reproducciones autorizadas), imágenes, videos, sonidos, gráficos, iconos, logotipos, isotipos, marcas, dibujos, emblemas, combinaciones de colores, combinación de letras y números, frases publicitarias u otro contenido digital o digitalizado (distinto de instrucciones de programa informático) y cada archivo de programa informático (ya sea que utilice uno o más de los anteriores archivos digitales o no) directa o indirectamente asociado por el Administrador con la dirección de Internet a la que corresponde el siguiente nombre de dominio: {{ config('app.url') }}</p>
        <p><i>Sitio de Tercero</i>: es cada dirección de Internet distinta del Sitio.</p>
        <p><i>Software No Autorizado</i>: uno o más archivos digitales, ejecutables o no, o programas informáticos distintos de Software Prohibido y desarrollados para modificar, por sí solos o vinculados con uno o más otros archivos digitales o programas informáticos (ya cuenten éstos con autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario o no), de manera actual o potencial, total o parcialmente, temporaria o definitivamente, con efecto inmediato o diferido, continuo o intermitente, sin la autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario, el funcionamiento regular (incluyendo, sin limitación, la confidencialidad, integridad o disponibilidad) del Sitio estipulado por el Administrador.</p>
        <p><i>Software Prohibido</i>: uno o más archivos digitales, ejecutables o no, o programas informáticos desarrollados para interferir, por sí solos o vinculados con uno o más otros archivos digitales o programas informáticos (ya sean éstos maliciosos o no), de manera actual o potencial, total o parcialmente, temporaria o definitivamente, con efecto inmediato o diferido, continuo o intermitente, con el funcionamiento regular (incluyendo, sin limitación, la confidencialidad, integridad o disponibilidad) del Sitio estipulado por el Administrador.</p>
        <p><i>Tribunales</i>: los órganos judiciales locales competentes por razón de la materia indicados en la Cláusula Tribunales Judiciales Competentes.</p>
        <p><i>TyC</i>: los presentes Términos y Condiciones del Sitio.</p>
        <p><i>Usuario</i>: cada persona humana que Accede al Sitio, Permanece en el Sitio y realiza la Actividad en el Sitio, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, y cada Usuario Necesario; estipulándose que la Actividad en el Sitio realizada con Credencial de Seguridad se considerará realizada por la persona humana que suministró, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, dicha Credencial de Seguridad.</p>
        <p><i>Usuario Necesario</i>: cada persona humana que es titular o delegada de la responsabilidad parental o representante necesaria, según el caso, de otra persona humana que Accede al Sitio, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, y no tiene 18 (dieciocho) años de edad cumplidos y no está emancipado por matrimonio o por otra causa no goza de capacidad civil para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio cumpliendo los TyC.</p>

        <h3>2. Finalidad de los TyC</h3>
        <p>(a) Los TyC:</p>
        <p class="ms-3">(I) se aplican y, por lo tanto, detallan la relación contractual entre el Usuario y el Administrador a propósito del Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio y la Salida del Sitio; y</p>
        <p class="ms-3">(II) no se aplican a ningún Sitio de Tercero ya sea antes del Acceso del Sitio, durante la Permanencia en el Sitio a partir del Acceso del Sitio de Tercero de que se trate mediante la utilización por el Usuario de uno o más enlaces a dicho Sitio de Tercero incluidos y habilitados en el Sitio para Acceder a dicho Sitio de Tercero o después de la Salida del Sitio.</p>
        <p>(b) La utilización por el Usuario de uno o más enlaces a un Sitio de Tercero incluidos y habilitados en el Sitio para Acceder a dicho Sitio de Tercero se rige especialmente por lo dispuesto en la Cláusula Sitios de Terceros.</p>

        <h3>3. Consecuencias de Acceder al Sitio</h3>
        <p>(a) Cada Acceso del Sitio automáticamente representa:</p>
        <p class="ms-3">(I) para el Usuario:</p>
        <p class="ms-4">(1) su aceptación sin condiciones y total de:</p>
        <p class="ms-5">(A) los TyC; y</p>
        <p class="ms-5">(B) las disposiciones sobre privacidad del Usuario en Internet y protección de Datos Personales establecidas en la Cláusula Privacidad y Protección de Datos Personales; y</p>
        <p class="ms-4">(2) sus manifestaciones según la Cláusula Manifestaciones del Usuario; y</p>
        <p class="ms-3">(II) para el Administrador: su autorización del Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio y la Salida del Sitio exclusivamente sobre la base de lo dispuesto en el sub-apartado (I).</p>
        <p>(b) A los fines de esta Cláusula los TyC son los publicados por el Administrador en el Sitio durante la Permanencia en el Sitio salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario.</p>

        <h3>4. Manifestaciones del Usuario</h3>
        <p>El Usuario manifiesta:</p>
        <p class="ms-3">(a) alternativamente:</p>
        <p class="ms-4">(I) tener 18 (dieciocho) años de edad cumplidos o estar emancipado por matrimonio y, en cualquier caso, gozar de capacidad civil para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio cumpliendo los TyC; o</p>
        <p class="ms-4">(II) no tener 18 (dieciocho) años de edad cumplidos y no estar emancipado por matrimonio o por otra causa no gozar de capacidad civil pero, no obstante ello, contar con autorización, asistencia, asesoramiento y supervisión de un Usuario Necesario para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio cumpliendo los TyC; y</p>
        <p class="ms-3">(b) ser Usuario Necesario de otro Usuario que no tiene 18 (dieciocho) años de edad cumplidos y no está emancipado por matrimonio o por otra causa no goza de capacidad civil pero, no obstante ello, cuenta con su autorización, asistencia, asesoramiento y supervisión para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio cumpliendo los TyC; y</p>
        <p class="ms-3">(c) no estar obligado por el Administrador para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio; y</p>
        <p class="ms-3">(d) no necesitar obtener autorización o consentimiento de una persona humana o jurídica o una Autoridad Pública para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio (excepto por la autorización de un Usuario Necesario, en su caso, y la autorización del Administrador conforme al apartado (a) sub-apartado (II) de la Cláusula Consecuencias de Acceder al Sitio) o, de lo contrario, contar con dicha autorización o dicho consentimiento; y</p>
        <p class="ms-3">(e) si Accede al Sitio por intermedio de un programa informático no autorizado previa y expresamente por el Administrador:</p>
        <p class="ms-4">(I) conocer que dicho programa informático no es Software Prohibido; y</p>
        <p class="ms-4">(II) conocer que dicho programa informático no es Software No Autorizado; y</p>
        <p class="ms-4">(III) no necesitar obtener autorización o consentimiento de una persona humana o jurídica o una Autoridad Pública para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio por intermedio de dicho programa informático (excepto por la autorización de un Usuario Necesario, en su caso, y la autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario) o, de lo contrario, contar con dicha autorización o dicho consentimiento.</p>

        <h3>5. Derechos del Usuario</h3>
        <p>Además de sus otros derechos establecidos por los TyC y la legislación aplicable, el Usuario tiene derecho también a:</p>
        <p class="ms-3">(a) poder consultar en el Sitio, en cualquier momento durante la Permanencia en el Sitio, la versión de los TyC vigente al momento de dicha consulta; y</p>
        <p class="ms-3">(b) obtener de la ayuda técnica que estuviere disponible en el Sitio asesoramiento sobre la solución de cualquier problema técnico que el Usuario hubiera encontrado para realizar la Actividad en el Sitio; y</p>
        <p class="ms-3">(c) decidir sobre la conveniencia y oportunidad de la Salida del Sitio a su entera discreción excepto que la Salida del Sitio se adelantare por causa de:</p>
        <p class="ms-4">(I) la ocurrencia de un evento de fuerza mayor; o</p>
        <p class="ms-4">(II) la operación de Software Prohibido; o</p>
        <p class="ms-4">(III) la decisión del Administrador debido:</p>
        <p class="ms-5">(1) al incumplimiento por el Usuario de los TyC; o</p>
        <p class="ms-5">(2) a un acto del Administrador conforme a la Cláusula Modificaciones y Otras Situaciones; o</p>
        <p class="ms-5">(3) al cumplimiento por el Administrador de una orden recibida de una Autoridad Pública; y</p>
        <p class="ms-3">(d) no ser considerado conectado al Sitio a partir de la Salida del Sitio; estipulándose, no obstante, que lo dispuesto en este apartado no impedirá la atribución al Usuario de la responsabilidad correspondiente por la Actividad en el Sitio cuya ejecución el Usuario hubiera programado durante la Permanencia en el Sitio y debiere finalizarse o debiere iniciarse y finalizarse después de la Salida del Sitio; y</p>
        <p class="ms-3">(e) ser informado oportuna y claramente por el Administrador, en el Sitio y/o por correo electrónico enviado al Usuario, de cualquier incumplimiento de los TyC de parte del Usuario que hubiera sido comprobado por el Administrador; estipulándose que el Usuario podrá remediar dicho incumplimiento sólo si el Administrador hubiera decidido a su entera discreción considerar que dicho incumplimiento es remediable por el Usuario y así se lo hubiera informado a éste; estipulándose, además, que la decisión del Administrador de considerar que dicho incumplimiento no es remediable por el Usuario será final a todos los efectos legales que corresponda.</p>

        <h3>6. Obligaciones del Usuario</h3>
        <p>Además de sus otras obligaciones establecidas por los TyC y la legislación aplicable, el Usuario se obliga también a:</p>
        <p class="ms-3">(a) durante la Permanencia en el Sitio:</p>
        <p class="ms-4">(I) antes de realizar la Actividad en el Sitio:</p>
        <p class="ms-5">(1) comprender los TyC; y</p>
        <p class="ms-5">(2) comprender las disposiciones del Sitio sobre privacidad del Usuario en Internet y protección de Datos Personales establecidas en la Cláusula Privacidad y Protección de Datos Personales; y</p>
        <p class="ms-5">(3) determinar con independencia del Administrador, por su propia iniciativa, a su exclusiva costa y bajo su exclusiva responsabilidad la legalidad de Permanecer en el Sitio y/o realizar la Actividad en el Sitio conforme a la legislación aplicable al Usuario, al Sitio y/o a la Actividad en el Sitio en vigencia al momento del Acceso del Sitio o de realizar dicha Actividad en el Sitio en el lugar donde el Usuario hubiere Accedido al Sitio; y</p>
        <p class="ms-5">(4) comprobar con independencia del Administrador, por su propia iniciativa, a su exclusiva costa y bajo su exclusiva responsabilidad la seguridad informática de la conexión que utilizare para Permanecer en el Sitio; y</p>
        <p class="ms-5">(5) suministrar de manera oportuna, completa, correcta y veraz los datos personales y/u otros datos u otra información que se le requiriere en el Sitio y/o por correo electrónico enviado por el Administrador como requisito para Permanecer en el Sitio y/o realizar la Actividad en el Sitio; y</p>
        <p class="ms-4">(II) realizar la Actividad en el Sitio siguiendo las instrucciones correspondientes, de manera acorde con la funcionalidad de dicha Actividad en el Sitio y respetando la letra y el espíritu de los TyC y la legislación aplicable; y</p>
        <p class="ms-4">(III) buscar, leer y comprender la información disponible en el Sitio y seguir las instrucciones correspondientes sobre la solución de cualquier problema que el Usuario hubiera encontrado para realizar la Actividad en el Sitio; y</p>
        <p class="ms-4">(IV) procurar de inmediato la ayuda técnica disponible en el Sitio, suministrar de manera oportuna, completa, correcta y veraz la información correspondiente y seguir las instrucciones que recibiere sobre la solución de cualquier problema que el Usuario hubiera encontrado para realizar la Actividad en el Sitio; y</p>
        <p class="ms-4">(V) mantener confidencial cada Credencial de Seguridad que generare; y</p>
        <p class="ms-4">(VI) informar de inmediato al Administrador sobre uno o más defectos, errores y vulnerabilidades del Sitio que el Usuario hubiera detectado involuntariamente; y</p>
        <p class="ms-4">(VII) abstenerse de:</p>
        <p class="ms-5">(1) transmitir al Sitio:</p>
        <p class="ms-6">(A) Software Prohibido; y</p>
        <p class="ms-6">(B) Software No Autorizado; y</p>
        <p class="ms-6">(C) contenido digital (incluyendo, sin limitación, textos, imágenes, videos, sonidos, gráficos, etc.) desacorde con la Actividad en el Sitio o los objetivos del Sitio o que incumpliere la letra o el espíritu de los TyC o la legislación aplicable (incluyendo, sin limitación, la legislación sobre propiedad intelectual, sobre marcas y designaciones y sobre patentes de invención y modelos de utilidad); y</p>
        <p class="ms-5">(2) intentar acceder y acceder a datos personales y/u otros datos u otra información propios o ajenos sin la autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-5">(3) intentar interferir e interferir con la confidencialidad, integridad o disponibilidad del Sitio; y</p>
        <p class="ms-5">(4) intentar detectar y detectar deliberadamente uno o más defectos, errores o vulnerabilidades del Sitio; y</p>
        <p class="ms-5">(5) informar en cualquier momento, por cualquier medio de comunicación y de cualquier forma a cualquier tercero (excepto una Autoridad Pública en ejercicio de sus funciones) sobre uno o más defectos, errores o vulnerabilidades del Sitio que el Usuario hubiera detectado involuntariamente; y</p>
        <p class="ms-3">(b) desde la Salida del Sitio:</p>
        <p class="ms-4">(I) mantener confidencial cada Credencial de Seguridad generada durante la Permanencia en el Sitio; y</p>
        <p class="ms-4">(II) Acceder al Sitio y generar una nueva y diferente Credencial de Seguridad en reemplazo de cada Credencial de Seguridad que hubiera generado por última vez y que hubiera dejado de ser confidencial por la causa que fuere; y</p>
        <p class="ms-4">(III) informar de inmediato al Administrador, en el Sitio y/o por correo electrónico enviado al Administrador, sobre cada Credencial de Seguridad que hubiera dejado de ser confidencial por la causa que fuere.</p>

        <h3>7. Requisitos para la Actividad en el Sitio</h3>
        <p>(a) El Administrador podrá en cualquier momento solicitar al Usuario, en el Sitio y/o por correo electrónico enviado al Usuario, de manera previa y expresa:</p>
        <p class="ms-3">(I) la aceptación expresa, sin condiciones y total de uno o más términos y condiciones:</p>
        <p class="ms-4">(1) complementarios de los TyC; y/o</p>
        <p class="ms-4">(2) específicos de la totalidad o parte de la Actividad en el Sitio; y/o</p>
        <p class="ms-3">(II) la confirmación o información de uno o más datos personales y/u otros datos u otra información del Usuario; y/o</p>
        <p class="ms-3">(III) el pago de una determinada suma de dinero de acuerdo con el procedimiento de pago que el Administrador informare previa y claramente al Usuario,</p>
        <p>como requisito para realizar, total o parcialmente, de manera temporaria o definitiva, la Actividad en el Sitio.</p>
        <p>(b) Si el Administrador realizare una solicitud conforme al apartado (a) entonces el Administrador podrá en cualquier momento también realizar una solicitud conforme al apartado (a) de la Cláusula Cuenta de Registro del Usuario.</p>

        <h3>8. Cuenta de Registro del Usuario</h3>
        <p>(a) El Administrador podrá en cualquier momento solicitar al Usuario, en el Sitio y/o por correo electrónico enviado al Usuario, de manera previa y expresa, la creación de una o más cuentas de registro, a nombre exclusivo del Usuario y con Credencial de Seguridad, como requisito para:</p>
        <p class="ms-3">(I) tener disponible en el Sitio, temporaria o definitivamente, información provista por el Administrador y/o uno o más terceros que no estará disponible para ningún otro Usuario que no hubiera creado una cuenta de registro conforme a este apartado; y/o</p>
        <p class="ms-3">(II) realizar, total o parcialmente, de manera temporaria o definitiva, la Actividad en el Sitio.</p>
        <p>(b) Cada cuenta de registro creada por el Usuario conforme al apartado (a):</p>
        <p class="ms-3">(I) será de titularidad y uso intransferibles; y</p>
        <p class="ms-3">(II) será de mantenimiento gratuito para el Usuario salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-3">(III) en cualquier momento:</p>
        <p class="ms-4">(1) podrá ser eliminada por decisión del Usuario sin expresión de causa salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-4">(2) podrá ser suspendida por hasta 90 (noventa) días o eliminada por decisión del Administrador fundada en:</p>
        <p class="ms-5">(A) el incumplimiento, total o parcial, temporario o definitivo, por el Usuario de los TyC o la legislación aplicable al Usuario, al Sitio y/o a la Actividad en el Sitio; o</p>
        <p class="ms-5">(B) una orden recibida de una Autoridad Pública.</p>
        <p>(c) Si el Administrador adoptare una decisión conforme al apartado (b) sub-apartado (III) punto (2) entonces el Administrador comunicará dicha decisión y su fundamentación por correo electrónico enviado al Usuario en forma previa, simultánea o posterior a la suspensión o eliminación, según el caso, de la cuenta de registro excepto que, a criterio exclusivo del Administrador considerando las circunstancias, dicha comunicación frustrare la eficacia de la suspensión o eliminación, según el caso, de dicha cuenta de registro.</p>

        <h3>9. Derechos del Administrador</h3>
        <p>Además de sus otros derechos establecidos por los TyC y la legislación aplicable, el Administrador tiene derecho también a:</p>
        <p class="ms-3">(a) informar a la Autoridad Pública que lo solicitare por escrito sobre el Usuario, la Permanencia en el Sitio y/o la Actividad en el Sitio; y</p>
        <p class="ms-3">(b) impedir el Acceso del Sitio, la Permanencia en el Sitio y/o la Actividad en el Sitio a la persona humana que hubiera perdido la condición de Usuario por causa del incumplimiento, total o parcial, reiterado o continuo, de los TyC o la legislación aplicable al Usuario, al Sitio y/o a la Actividad en el Sitio.</p>

        <h3>10. Modificaciones y Otras Situaciones</h3>
        <p>(a) El Administrador:</p>
        <p class="ms-3">(I) podrá a su exclusivo criterio, en cualquier momento y sin necesidad de dar aviso o explicación al Usuario en forma previa, simultánea o posterior:</p>
        <p class="ms-4">(1) modificar, total o parcialmente, de manera temporaria o definitiva:</p>
        <p class="ms-5">(A) el Sitio; y/o</p>
        <p class="ms-5">(B) los TyC; y</p>
        <p class="ms-4">(2) impedir con alcance general, total o parcialmente, de manera temporaria o definitiva, el Acceso del Sitio; y</p>
        <p class="ms-4">(3) cerrar, total o parcialmente, de manera temporaria o definitiva, el Sitio; y</p>
        <p class="ms-3">(II) sin perjuicio de lo dispuesto en el sub-apartado (I), podrá comunicar al Usuario, en el Sitio y/o por correo electrónico enviado al Usuario, en la oportunidad y durante el tiempo que en cada caso el Administrador determinare:</p>
        <p class="ms-4">(1) una modificación, total o parcial, temporaria o definitiva:</p>
        <p class="ms-5">(A) del Sitio; y/o</p>
        <p class="ms-5">(B) de los TyC; y</p>
        <p class="ms-4">(2) un impedimento, total o parcial, temporario o definitivo, al Acceso del Sitio; y</p>
        <p class="ms-4">(3) el cierre, total o parcial, temporario o definitivo, del Sitio; y</p>
        <p class="ms-3">(III) no estará obligado por el Usuario para:</p>
        <p class="ms-4">(1) modificar, total o parcialmente, de manera temporaria o definitiva, el Sitio para mantenerlo actualizado; o</p>
        <p class="ms-4">(2) mantener habilitada para el Usuario una o más funcionalidades del Sitio que el Administrador hubiera deshabilitado debido a la modificación del Sitio durante un tiempo (determinado o indeterminado) posterior a la implementación de una modificación del Sitio; o</p>
        <p class="ms-4">(3) mantener disponible para el Usuario la totalidad o parte del Sitio que el Administrador hubiera eliminado debido a la modificación del Sitio durante un tiempo (determinado o indeterminado) posterior a la implementación de una modificación.</p>
        <p>(b) El Usuario:</p>
        <p class="ms-3">(I) no estará obligado por el Administrador para aceptar, total o parcialmente, ninguna modificación del Sitio y/o de los TyC realizada por el Administrador; y</p>
        <p class="ms-3">(II) deberá manifestar expresamente, en el Sitio y/o por correo electrónico enviado al Administrador, en la oportunidad y durante el tiempo que en cada caso el Administrador determinare, haber leído, comprendido y aceptado sin condiciones y totalmente la modificación de los TyC como requisito previo para Permanecer en el Sitio y/o realizar la Actividad en el Sitio; y</p>
        <p class="ms-3">(III) deberá abstenerse de Acceder al Sitio si no tuviere intención de cumplir con lo dispuesto en el sub-apartado (II); y</p>
        <p class="ms-3">(IV) no deberá Permanecer en el Sitio o realizar la Actividad en el Sitio si no hubiera cumplido con lo dispuesto en el sub-apartado (II).</p>

        <h3>11. Sitios de Terceros</h3>
        <p>(a) El Sitio podrá en cualquier momento, temporaria o definitivamente, incluir y habilitar uno o más enlaces a uno o más Sitios de Terceros.</p>
        <p>(b) Ningún Sitio de Tercero será considerado de propiedad del Administrador o licenciado al Administrador salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario.</p>
        <p>(c) La inclusión, habilitación, sustitución, deshabilitación y eliminación de un enlace a un Sitio de Tercero:</p>
        <p class="ms-3">(I) será realizada por el Administrador con la finalidad de mejorar la interacción entre el Usuario y el Sitio durante la Permanencia en el Sitio salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-3">(II) se regirá por lo dispuesto en la Cláusula Modificaciones y Otras Situaciones.</p>
        <p>(d) El Usuario no estará obligado por el Administrador a:</p>
        <p class="ms-3">(I) Acceder a ningún Sitio de Tercero; o</p>
        <p class="ms-3">(II) utilizar uno o más enlaces a un Sitio de Tercero incluidos y habilitados en el Sitio para Acceder a dicho Sitio de Tercero,</p>
        <p>salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario.</p>
        <p>(e) Como consecuencia de lo establecido en el apartado (d):</p>
        <p class="ms-3">(I) el Administrador no será responsable porque:</p>
        <p class="ms-4">(1) un Sitio de Tercero:</p>
        <p class="ms-5">(A) cumpla, total o parcialmente, de manera temporaria o definitiva, con la legislación aplicable al Usuario y/o a dicho Sitio de Tercero en vigencia al momento de Acceder a dicho Sitio de Tercero en el lugar donde el Usuario Accediere a dicho Sitio de Tercero; o</p>
        <p class="ms-5">(B) esté operativo, total o parcialmente, de manera temporaria o definitiva, al momento en que el Usuario intentare Acceder a dicho Sitio de Tercero; o</p>
        <p class="ms-5">(C) establezca para Acceder a dicho Sitio de Tercero requisitos del Usuario no más exigentes (cuantitativa y/o cualitativamente) que los requisitos establecidos en los TyC para el Acceso del Sitio al momento que el Usuario intentare Acceder a dicho Sitio de Tercero; o</p>
        <p class="ms-5">(D) funcione, total o parcialmente, de manera temporaria o definitiva, de manera acorde con los términos y condiciones de dicho Sitio de Tercero o, en su defecto, lo estipulado por la persona propietaria y/o administradora de dicho Sitio de Tercero; o</p>
        <p class="ms-5">(E) ofrezca contenido digital (incluyendo, sin limitación, textos, imágenes, videos, sonidos, gráficos, etc.) completo, exacto, actual y acorde con la funcionalidad o los objetivos de dicho Sitio de Tercero o que respete la letra y el espíritu de los términos y condiciones de dicho Sitio de Tercero y la legislación aplicable; o</p>
        <p class="ms-5">(F) posibilite una interacción entre el Usuario y dicho Sitio de Tercero no menos satisfactoria (cuantitativa y/o cualitativamente) que la interacción entre el Usuario y el Sitio durante la Permanencia en el Sitio; o</p>
        <p class="ms-4">(2) el Usuario:</p>
        <p class="ms-5">(A) reúna todos los requisitos que un Sitio de Tercero estableciere para Acceder al mismo; o</p>
        <p class="ms-5">(B) no sufra, de manera directa o indirecta, actual o potencialmente, temporaria o definitivamente, con efecto inmediato o diferido, un daño y/o perjuicio (patrimonial y/o moral) por causa de Acceder a un Sitio de Tercero; y</p>
        <p class="ms-3">(II) el Usuario será responsable por determinar con independencia del Administrador, por su propia iniciativa, a su exclusiva costa y bajo su exclusiva responsabilidad:</p>
        <p class="ms-4">(1) la legalidad de Acceder a un Sitio de Tercero conforme a la legislación aplicable al Usuario y/o a dicho Sitio de Tercero en vigencia al momento de Acceder a dicho Sitio de Tercero en el lugar donde el Usuario tuviere intención de Acceder a dicho Sitio de Tercero; y</p>
        <p class="ms-4">(2) la necesidad o conveniencia para el Usuario y los riesgos para éste y/o terceros de Acceder a un Sitio de Tercero conforme a las circunstancias del Usuario al momento de Acceder a dicho Sitio de Tercero en el lugar donde el Usuario tuviere intención de Acceder a dicho Sitio de Tercero; y</p>
        <p class="ms-4">(3) la aceptación o el rechazo de los términos y condiciones de un Sitio de Tercero.</p>

        <h3>12. Propiedad Intelectual</h3>
        <p>(a) El Sitio:</p>
        <p class="ms-3">(I) es íntegramente de propiedad del Administrador o está licenciado al Administrador salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-3">(II) está protegido por la legislación sobre propiedad intelectual, sobre marcas y designaciones y sobre patentes de invención y modelos de utilidad en todo cuanto corresponde.</p>
        <p>(b) El Usuario:</p>
        <p class="ms-3">(I) se abstendrá de:</p>
        <p class="ms-4">(1) almacenar en cualquier dispositivo, de cualquier forma y por cualquier causa que fuere, ya sea con finalidad de lucrar o no, la totalidad o parte del Sitio sin la autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-4">(2) modificar, copiar, duplicar, reproducir, transmitir, circular o distribuir a cualquier tercero, de cualquier forma y por cualquier causa que fuere, ya sea con finalidad de lucrar o no, la totalidad o parte del Sitio sin la autorización previa y expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; y</p>
        <p class="ms-4">(3) atribuirse la propiedad y apropiarse, de cualquier forma y por cualquier causa que fuere, ya sea con finalidad de lucrar o no, de la totalidad o parte del Sitio; y</p>
        <p class="ms-4">(4) atribuir la propiedad, de cualquier forma y por cualquier causa que fuere, ya sea con finalidad de lucrar o no, de la totalidad o parte del Sitio a una persona distinta del Administrador; y</p>
        <p class="ms-4">(5) atribuirse una licencia o permiso de uso y disponer como licenciatario o permisionario, total o parcialmente, de cualquier forma y por cualquier causa que fuere, ya sea con finalidad de lucrar o no, de la totalidad o parte del Sitio; y</p>
        <p class="ms-3">(II) otorgará al Administrador automáticamente al momento de transmitirlo al Sitio una licencia o permiso de uso irrevocable, a perpetuidad, sin exclusividad, transferible y sin derecho a compensación alguna en relación con cualquier contenido de propiedad del Usuario que éste no debiere abstenerse de transmitir al Sitio conforme a la Cláusula Obligaciones del Usuario y que el Usuario transmitiere al Sitio durante la Permanencia en el Sitio; estipulándose que el Administrador no tendrá obligación de dar aviso previo al Usuario sobre la oportunidad y finalidad del uso de dicho contenido de parte del Administrador; estipulándose, no obstante, que el Administrador no utilizará dicho contenido para una finalidad ilícita.</p>

        <h3>13. Exclusión de Responsabilidad</h3>
        <p>(a) El Usuario reconoce y acepta que el Acceso del Sitio, la Permanencia en el Sitio y la Actividad en el Sitio:</p>
        <p class="ms-3">(I) no es un deber ni una obligación del Usuario creado o impuesta, respectivamente, por el Administrador; y</p>
        <p class="ms-3">(II) es realizado:</p>
        <p class="ms-4">(1) por su propia iniciativa; y</p>
        <p class="ms-4">(2) a su exclusiva costa; y</p>
        <p class="ms-4">(3) con comprensión de los TyC; y</p>
        <p class="ms-4">(4) bajo su exclusiva responsabilidad.</p>
        <p>(b) Como consecuencia de lo establecido en el apartado (a) el Administrador no será responsable por cualquier daño y/o perjuicio, patrimonial y/o moral, causado, directa o indirectamente, de manera actual o potencial, al Usuario como consecuencia:</p>
        <p class="ms-3">(I) de la imposibilidad, temporaria o definitiva, de Acceder al Sitio, Permanecer en el Sitio, realizar la Actividad en el Sitio o Salir del Sitio, total o parcialmente, por una causa técnica o legal no imputable al Administrador; o</p>
        <p class="ms-3">(II) del Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio o la Salida en el Sitio ya sea en cumplimiento o incumplimiento de los TyC; o</p>
        <p class="ms-3">(III) en relación con un Sitio de Tercero:</p>
        <p class="ms-4">(1) de Acceder a dicho Sitio de Tercero conforme al apartado (d) de la Cláusula Sitios de Terceros salvo que el Acceso de dicho Sitio de Tercero hubiera ocurrido por indicación expresa del Administrador en el Sitio y/o por correo electrónico enviado al Usuario; estipulándose, no obstante, que el Administrador no será responsable si dicha indicación hubiera sido consecuencia del cumplimiento de una disposición de la legislación aplicable u orden recibida de una Autoridad Pública; o</p>
        <p class="ms-4">(2) del contenido de dicho Sitio de Tercero; o</p>
        <p class="ms-4">(3) de la actividad realizada en dicho Sitio de Tercero; o</p>
        <p class="ms-4">(4) del almacenamiento en el dispositivo utilizado por el Usuario para Acceder a dicho Sitio de Tercero y la utilización por éste de una o más Cookies de dicho Sitio de Tercero; y</p>
        <p class="ms-4">(5) de la transmisión al dispositivo utilizado por el Usuario para Acceder a dicho Sitio de Tercero y del almacenamiento y de la ejecución en dicho dispositivo, temporaria o definitivamente, con efecto inmediato o diferido, de software malicioso como consecuencia del Acceso de dicho Sitio de Tercero; o</p>
        <p class="ms-3">(IV) de la pérdida, total o parcial, temporaria o definitiva, de la confidencialidad de una Credencial de Seguridad por una causa no imputable al Administrador; o</p>
        <p class="ms-3">(V) de la transmisión al dispositivo utilizado por el Usuario para Acceder al Sitio y del almacenamiento y de la ejecución en dicho dispositivo, temporaria o definitivamente, con efecto inmediato o diferido, por una causa no imputable al Administrador, de software malicioso como consecuencia del Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio o la Salida del Sitio; o</p>
        <p class="ms-3">(VI) del incumplimiento por el Usuario, de manera temporaria o definitiva y por cualquier causa que fuere, de los TyC o un deber u obligación creado o impuesto por el Administrador al Usuario en relación con un incumplimiento por el Usuario de los TyC.</p>
        <p>(c) Nada en el Sitio deberá ser interpretado por el Usuario como asesoramiento profesional de ningún tipo (incluyendo, sin limitación, jurídico, contable, tributario o financiero) y, en consecuencia, el Usuario deberá obtener con independencia del Administrador, por su propia iniciativa, a su exclusiva costa y bajo su exclusiva responsabilidad el asesoramiento profesional del tipo de que se trate que el Usuario considerare necesario o conveniente conforme a sus circunstancias salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario.</p>

        <h3>14. Privacidad y Protección de Datos Personales</h3>
        <p>(a) El Sitio ha sido desarrollado con respeto por la privacidad del Usuario en Internet y considerando el deber del Administrador de proteger, conforme a la Ley, cualesquiera datos personales que el Usuario transmitiere al Sitio en relación con el Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio y la Salida del Sitio.</p>
        <p>(b) En cualquier momento durante la Permanencia en el Sitio el Usuario podrá consultar en la sección “Política de Privacidad” del Sitio ({{ route('legal.terms') }}) la Política de Privacidad y Protección de Datos Personales vigente en el Sitio al momento de dicha consulta.</p>

        <h3>15. Comunicaciones</h3>
        <p>(a) El Usuario podrá comunicarse con el Administrador:</p>
        <p class="ms-3">(I) en el Sitio; o</p>
        <p class="ms-3">(II) sólo durante el tiempo que razones técnicas impidieren transmitir en el Sitio la comunicación al Administrador, por correo electrónico enviado a la dirección del Administrador indicada en la Cláusula Definiciones.</p>
        <p>(b) El Administrador podrá comunicarse con el Usuario:</p>
        <p class="ms-3">(I) en el Sitio; y/o</p>
        <p class="ms-3">(II) por correo electrónico enviado a la dirección que el Usuario hubiera suministrado al Administrador en el Sitio.</p>
        <p>(c) Las comunicaciones entre el Usuario y el Administrador no serán confidenciales respecto del Administrador y el Usuario y serán confidenciales respecto de toda otra persona humana o jurídica salvo una Autoridad Pública en ejercicio de sus funciones.</p>

        <h3>16. Cesión</h3>
        <p>El Usuario no se obligará a ceder ni cederá a tercero alguno:</p>
        <p class="ms-3">(a) su posición contractual en los TyC; o</p>
        <p class="ms-3">(b) cualquiera de las obligaciones que le atribuyen los TyC o de los derechos que pudiere tener frente al Administrador por causa de los TyC o la legislación aplicable al Sitio.</p>

        <h3>17. Validez</h3>
        <p>La invalidez de una o más Cláusulas (pero no de los TyC en su totalidad) que sobrevenga después de su publicación en el Sitio por una causa que no fuere imputable al Administrador o al Usuario o a ambos no afectará la validez de las restantes Cláusulas.</p>

        <h3>18. Domicilio Especial</h3>
        <p>El Administrador constituye domicilio en la siguiente dirección: Avenida 28 De Julio 559, Miraflores, Lima, Perú.</p>

        <h3>19. Ley Aplicable</h3>
        <p>Los TyC se rigen exclusivamente por la ley de la República del Perú.</p>

        <h3>20. Tribunales Judiciales Competentes</h3>
        <p>Toda cuestión (litigiosa o no) relacionada con los TyC será resuelta exclusivamente por los tribunales judiciales competentes por razón de la materia con asiento en la ciudad de Lima, Perú.</p>
      </div>

      <div class="card card-body">
        <h2>Política de privacidad</h2>
        <p>Última actualización: 09/02/2021</p>

        <h3>1. Definiciones</h3>
        <p><i>Acceder</i>: una o más acciones del Usuario necesarias: tratándose del Sitio, para el Acceso del Sitio; o, tratándose de un Sitio de Tercero, para abrir conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) una o más conexiones HTTP o HTTPS, respectivamente, entre la dirección de Internet de dicho Sitio de Tercero y la dirección de Internet de un dispositivo utilizado por el Usuario para abrir cada dicha conexión.</p>
        <p><i>Acceso del Sitio</i>: la apertura conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) de una o más conexiones HTTP o HTTPS, respectivamente, entre la dirección de Internet del Sitio y la dirección de Internet de un dispositivo utilizado por el Usuario para abrir cada dicha conexión.</p>
        <p><i>Actividad en el Sitio</i>: la utilización por el Usuario de una o más funcionalidades incluidas y habilitadas en el Sitio.</p>
        <p><i>Administrador</i>: la siguiente persona jurídica: Benlos S.A.C., con domicilio en la Avenida 28 De Julio 559, Miraflores, Lima, Perú, y con correo electrónico en {{ env('MAIL_ADDRESS_CONTACT') }}.</p>
        <p><i>Autoridad Pública</i>: cualquier órgano legislativo, ejecutivo o judicial de carácter nacional, regional, departamental, provincial o municipal.</p>
        <p><i>Credencial de Seguridad</i>: uno o más datos personales y/u otros datos u otra información suministrados por una persona humana, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, para otorgar a dicha persona humana una identidad única e inequívoca como Usuario.</p>
        <p><i>Dato Personal</i>: cada dato de propiedad del Usuario (incluyendo, sin limitación, cada dato sobre el dispositivo utilizado por el Usuario para Acceder al Sitio -modelo, sistema operativo, conexión, etc.- y la ubicación geográfica del Usuario durante la Permanencia en el Sitio) que cumple los siguientes requisitos: (1) conforme a la ley peruana no está prohibido al Administrador recolectarlo del Usuario conforme a la Cláusula Recolección de Datos Personales; y (2) no es de conocimiento público al momento en que el Administrador lo recolecta del Usuario conforme a la Cláusula Recolección de Datos Personales.</p>
        <p><i>Permanecer en el Sitio</i>: una o más acciones del Usuario, en el Sitio y conforme a los TyC, necesarias para prolongar la Permanencia en el Sitio.</p>
        <p><i>Permanencia en el Sitio</i>: el tiempo que transcurriere desde, e incluyendo, el Acceso del Sitio hasta, e incluyendo, la Salida del Sitio.</p>
        <p><i>Propietario</i>: el Administrador.</p>
        <p><i>Salida del Sitio</i>: el cierre conforme al protocolo de Internet denominado Hypertext Transfer Protocol (HTTP) o al protocolo de Internet denominado Hypertext Transfer Protocol Secure (HTTPS) de la única o la última, según el caso, conexión HTTP o HTTPS, respectivamente, abierta por el Acceso del Sitio.</p>
        <p><i>Sitio</i>: cada archivo digital vacío o conteniendo uno o más textos (originales o reproducciones autorizadas), imágenes, videos, sonidos, gráficos, iconos, logotipos, isotipos, marcas, dibujos, emblemas, combinaciones de colores, combinación de letras y números, frases publicitarias u otro contenido digital o digitalizado (distinto de instrucciones de programa informático) y cada archivo de programa informático (ya sea que utilice uno o más de los anteriores archivos digitales o no) directa o indirectamente asociado por el Administrador con la dirección de Internet a la que corresponde el siguiente nombre de dominio: {{ config('app.url') }}</p>
        <p><i>Sitio de Tercero</i>: es cada dirección de Internet distinta del Sitio.</p>
        <p><i>TyC</i>: los presentes Términos y Condiciones del Sitio.</p>
        <p><i>Usuario</i>: cada persona humana que Accede al Sitio, Permanece en el Sitio y realiza la Actividad en el Sitio, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, y cada Usuario Necesario; estipulándose que la Actividad en el Sitio realizada con Credencial de Seguridad se considerará realizada por la persona humana que suministró, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, dicha Credencial de Seguridad.</p>
        <p><i>Usuario Necesario</i>: cada persona humana que es titular o delegada de la responsabilidad parental o representante necesaria, según el caso, de otra persona humana que Accede al Sitio, por sí misma o por intermedio de un programa informático no autorizado previa y expresamente por el Administrador, y no tiene 18 (dieciocho) años de edad cumplidos y no está emancipado por matrimonio o por otra causa no goza de capacidad civil para Acceder al Sitio, Permanecer en el Sitio y realizar la Actividad en el Sitio cumpliendo los TyC.</p>

        <h3>2. Desarrollo del Sitio</h3>
        <p>(a) El Sitio ha sido desarrollado con respeto por la privacidad del Usuario en Internet y considerando el deber del Administrador de proteger, conforme a la ley peruana, cualesquiera Datos Personales que el Usuario transmitiere al Sitio en relación con el Acceso del Sitio, la Permanencia en el Sitio, la Actividad en el Sitio y la Salida del Sitio.</p>
        <p>(b) La presente Política de Privacidad y Protección de Datos Personales es parte de los TyC y debe ser leída e interpretada en conjunto con los TyC.</p>

        <h3>3. Recolección de Datos Personales</h3>
        <p>Cada Acceso del Sitio automáticamente representa para el Usuario su consentimiento sin condiciones para que el Administrador pueda recolectar, en el Sitio y/o por correo electrónico recibido del Usuario, uno o más Datos Personales con las siguientes finalidades salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario:</p>
        <p class="ms-3">(a) mejorar la interacción entre el Usuario y el Sitio durante la Permanencia en el Sitio; y</p>
        <p class="ms-3">(b) elaborar estadísticas anónimas (es decir, no susceptibles de posibilitar la identificación del Usuario) del Sitio; y</p>
        <p class="ms-3">(c) cumplir una orden de una Autoridad Pública recibida por el Administrador; y</p>
        <p class="ms-3">(d) Promocionales.</p>

        <h3>4. Almacenamiento de Datos Personales</h3>
        <p>El Administrador almacenará los Datos Personales en una base de datos cuya administración será responsabilidad exclusiva del Administrador en el siguiente domicilio: Avenida 28 De Julio 559, Miraflores, Lima, Perú.</p>

        <h3>5. Gestión de Datos Personales</h3>
        <p>Los Datos Personales que el Administrador recolectare conforme a la Cláusula Recolección de Datos Personales podrán ser almacenados, procesados y transferidos exclusivamente por:</p>
        <p class="ms-3">(a) el Administrador; y</p>
        <p class="ms-3">(b) cada persona humana o jurídica con la que el Administrador celebrare un contrato de transferencia o cesión de uno o más Datos Personales; y</p>
        <p class="ms-3">(c) cada Autoridad Pública que requiriere al Administrador la transferencia o cesión de uno o más Datos Personales por resolución judicial y cuando medien razones fundadas relativas a la seguridad pública, la defensa nacional o la salud pública.</p>

        <h3>6. Derechos del Usuario</h3>
        <p>(a) El Usuario podrá solicitar al Administrador:</p>
        <p class="ms-3">(I) el acceso a uno o más Datos Personales; y</p>
        <p class="ms-3">(II) la actualización de uno o más Datos Personales que hubieran perdido vigencia por haber cambiado las circunstancias del Usuario; y</p>
        <p class="ms-3">(III) la rectificación de uno o más Datos Personales inexactos o incompletos; y</p>
        <p class="ms-3">(IV) el bloqueo de uno o más Datos Personales; y</p>
        <p class="ms-3">(V) la supresión de uno o más Datos Personales.</p>
        <p>(b) Cada solicitud del Usuario conforme al apartado (a) deberá ser efectuada mediante:</p>
        <p class="ms-3">(I) una carta documento si el Usuario solicitare acceder a uno o más Datos Personales; o</p>
        <p class="ms-3">(II) una carta simple, acompañada de una fotocopia simple de su Documento Nacional de Identidad o Pasaporte vigente, si el Usuario solicitare la actualización, la rectificación, el bloqueo o la supresión de uno o más Datos Personales.</p>
        <p>(c) El Usuario deberá entregar o causar que se entregue la comunicación correspondiente según el apartado (b) en el domicilio del Administrador indicado en la Cláusula Almacenamiento de Datos Personales.</p>
        <p>(d) El Administrador:</p>
        <p class="ms-3">(I) no estará obligado a responder favorablemente:</p>
        <p class="ms-4">(1) una solicitud de acceso, rectificación y/o supresión de uno o más Datos Personales recibida del Usuario conforme al apartado (a) si el cumplimiento con la solicitud de que se trate afectare la protección de la defensa de la Nación, del orden y la seguridad públicos o de los derechos e intereses de terceros; o</p>
        <p class="ms-4">(2) una solicitud de acceso de uno o más Datos Personales recibida del Usuario conforme al apartado (a) sub-apartado (I) si dicha solicitud no estuviere fechada por lo menos 6 (seis) meses después de la fecha de la última solicitud de acceso de Datos Personales que el Administrador hubiera recibido del Usuario conforme al apartado (a) sub-apartado (I) salvo que el Usuario demostrare razonablemente al Administrador (a criterio exclusivo del Administrador) que tiene un interés legítimo para acceder a los Datos Personales de que se trate antes de transcurrir 6 (seis) meses desde de la fecha de aquella última solicitud de acceso; o</p>
        <p class="ms-4">(3) una solicitud de supresión de uno o más Datos Personales recibida del Usuario conforme al apartado (a) sub-apartado (V) si la supresión solicitada pudiere causar perjuicios a derechos o intereses legítimos de terceros o impidiere al Administrador cumplir una obligación legal de conservar los Datos Personales de que se trate; y</p>
        <p class="ms-3">(II) informará los fundamentos de cada negativa conforme al sub-apartado (I) mediante una comunicación escrita dirigida al domicilio que el Usuario hubiera informado en la solicitud rechazada de que se trate.</p>

        <h3>7. Modificaciones</h3>
        <p>(a) El Administrador:</p>
        <p class="ms-3">(I) podrá a su exclusivo criterio, en cualquier momento y sin necesidad de dar aviso o explicación al Usuario en forma previa, simultánea o posterior, modificar, total o parcialmente, de manera temporaria o definitiva, esta Política de Privacidad y Protección de Datos Personales; y</p>
        <p class="ms-3">(II) sin perjuicio de lo dispuesto en el sub-apartado (I), podrá comunicar al Usuario, en el Sitio y/o por correo electrónico enviado al Usuario, en la oportunidad y durante el tiempo que en cada caso el Administrador determinare, una modificación, total o parcial, temporaria o definitiva, de esta Política de Privacidad y Protección de Datos Personales.</p>
        <p>(b) El Usuario:</p>
        <p class="ms-3">(I) no estará obligado a aceptar, total o parcialmente, ninguna modificación de esta Política de Privacidad y Protección de Datos Personales realizada por el Administrador; y</p>
        <p class="ms-3">(II) deberá manifestar expresamente, en el Sitio y/o por correo electrónico enviado al Administrador, en la oportunidad y durante el tiempo que en cada caso el Administrador determinare, haber leído, comprendido y aceptado sin condiciones y totalmente la modificación de esta Política de Privacidad y Protección de Datos Personales como requisito previo para Permanecer en el Sitio y/o realizar la Actividad en el Sitio; y</p>
        <p class="ms-3">(III) deberá abstenerse de Acceder al Sitio si no tuviere intención de cumplir con lo dispuesto en el sub-apartado (II); y</p>
        <p class="ms-3">(IV) no deberá Permanecer en el Sitio o realizar la Actividad en el Sitio si no hubiera cumplido con lo dispuesto en el sub-apartado (II).</p>
        <p>(c) A los fines de esta Cláusula la Política de Privacidad y Protección de Datos Personales es la publicada por el Administrador en el Sitio durante la Permanencia en el Sitio salvo indicación expresa en contrario del Administrador en el Sitio y/o por correo electrónico enviado al Usuario.</p>

        <h3>8. Sitio de Tercero</h3>
        <p>Esta Política de Privacidad y Protección de Datos Personales no se aplica a ningún Sitio de Tercero ya sea antes del Acceso del Sitio, durante la Permanencia en el Sitio a partir del Acceso del Sitio de Tercero de que se trate mediante la utilización por el Usuario de uno o más enlaces a dicho Sitio de Tercero incluidos y habilitados en el Sitio para Acceder a dicho Sitio de Tercero o después de la Salida del Sitio.</p>

        <h3>9. Ley Aplicable</h3>
        <p>Esta Política de Privacidad y Protección de Datos Personales se rige exclusivamente por la ley de la República del Perú.</p>
      </div>
    </div>
  </div>
</main>
@endsection
