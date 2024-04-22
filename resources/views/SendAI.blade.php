<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Envío</title>
</head>
<body>
    <h1>Resultado de Envío</h1>

    <h2>Datos enviados al servicio:</h2>
    <pre>{{ json_encode($formattedResults, JSON_PRETTY_PRINT) }}</pre>

    <h2>Respuesta del servicio:</h2>
    <pre>{{ json_encode($response->json(), JSON_PRETTY_PRINT) }}</pre>

    @if ($response->successful())
        <p>Los resultados se enviaron exitosamente.</p>
    @else
        <p>Ocurrió un error al enviar los resultados.</p>
    @endif
</body>
</html>
