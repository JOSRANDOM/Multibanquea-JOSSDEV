<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/serum/css/style.css') }}">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3" id="container">
        <div id="map"></div>
        <div id="sidebar">

        <!-- Elemento select -->
        <select class="js-example-basic-single" name="centros" id="centros_salud"></select>



        <script async defer>
            $(document).ready(function () {
                // Inicializar Select2
                $('.js-example-basic-single').select2();

                // Obtener datos desde la API (puedes reemplazar la URL con la de tu API)
                $.ajax({
                    url: 'https://saludgeoapi.up.railway.app/health_centers?limit=10000',
                    method: 'GET',
                    success: function (data) {
                        // Llenar dinámicamente las opciones del select
                        var select = $('#centros_salud');
                        $.each(data, function (index, item) {
                            select.append('<option value="' + item.codigo_unico + '">' + item.nombre_del_establecimiento + '</option>');
                        });

                        // Actualizar Select2 después de agregar las opciones
                        select.trigger('change');
                    },
                    error: function (error) {
                        console.log('Error al obtener datos desde la API');
                    }
                });
            });
        </script>

<div id="searchInputContainer">
    <button id="searchButton" onclick="realizarBusqueda()">
        <i class="fa fa-search"> BUSCAR</i>
    </button>
</div>

      <!-- Sección Leyendas en la columna derecha -->
      <div id="sidebar-content" class="sidebar-section">
        <!-- Sección Leyendas -->
        <div class="sidebar-content-section" id="leyendas-content">
          <h4>Leyendas</h4>
          <div id="leyendas-info"></div>
          <p id="zona"></p>
          <p id="healthCenterName"></p>
          <p id="leyendaProfesionales"></p>
          <p id="numPoliceStations"></p>
          <p id="numMarkets"></p>
          <p id="aeropuerto"></p>
          <p id="luzInfo"></p>
          <p id="aguaInfo"></p>

          <div id="mobileNetworks"></div>


        </div>
      </div>
    </div>

    <script src="{{ asset('assets/pages/serum/js\main.js') }}"></script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback&callback=iniciarMap"
      onerror="handleError()"></script>
    <script>
      function mostrarContenido(seccion) {
        // Ocultar todos los contenidos
        document.getElementById('leyendas-content').style.display = 'none';

        // Mostrar el contenido de la sección clickeada
        document.getElementById(`${seccion}-content`).style.display = 'grid';

        if (seccion === 'leyendas') {
          mostrarLeyendasInfo();
        }
      }

    </script></body>




</html>

