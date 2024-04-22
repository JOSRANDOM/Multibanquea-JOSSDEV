const urlList = "https://saludgeoapi.up.railway.app/health_centers?limit=50";
const baseDetailsUrl = "https://saludgeoapi.up.railway.app/health_centers/";

let allData = null; // Variable para almacenar todos los datos
let displayedData = []; // Variable para almacenar datos mostrados en el mapa



fetch(urlList)
    .then(response => response.json())
    .then(data => {
        // Limitar la cantidad de registros a 100 para la carga inicial
        const initialData = data.slice(0, 30);

        const healthCenters = initialData.map(center => {
            const detailsUrl = baseDetailsUrl + center.codigo_unico;
            return fetch(detailsUrl)
                .then(response => response.json())
                .then(details => ({
                    type: 'health_center',
                    nombre: details.health_center.nombre_del_establecimiento,
                    departamento: details.health_center.departamento,
                    provincia: details.health_center.provincia,
                    distrito: details.health_center.distrito,
                    latitud: parseFloat(details.health_center.lat),
                    longitud: parseFloat(details.health_center.lon),
                    police_stations: details.police_stations.map(station => ({
                        type: 'police_station',
                        nombre: station.nombredi,
                        latitud: parseFloat(station.gpslatitud_inf),
                        longitud: parseFloat(station.gpslongitud_inf),
                        inf110_tot: station.inf110_tot
                    })),
                    markets: details.markets.map(market => ({
                        type: 'market',
                        nombre: market["nombre del mercado"],
                        latitud: parseFloat(market.gps_lat),
                        longitud: parseFloat(market.gps_lon),
                        altitud: parseFloat(market.gps_alt)
                    })),
                    mobile_networks: details.mobile_network.map(mobile_network => ({
                        type: 'mobile_network',
                        nombre: mobile_network["empresa_operadora"]
                    })),
                    aeroports: details.aeroports.map(aeroport => ({
                        type: 'aeroport',
                        nombre: aeroport.nombre,
                        latitud: parseFloat(aeroport.latitud),
                        longitud: parseFloat(aeroport.longitud),
                        lugar: aeroport.provincia
                    })),
                    health_center_professional_info: details.health_center_professional_info.map(profesionnal => ({
                        type: 'profesionnal',
                        profesion: profesionnal.profesion,
                        n_prof: profesionnal.n_prof,
                    })),
                    service_water: details.service_water.map(service_water => ({
                        type: 'service_water',
                        profesion: service_water.codigo
                    })),
                    service_ligth: details.service_ligth.map(service_ligth => ({
                        type: 'service_ligth',
                        profesion: service_ligth.codigo
                    })),
                }));


        });

        return Promise.all(healthCenters);

    })
    .then(combinedData => {
        console.log(combinedData);
        iniciarMap(combinedData);
    })
    .catch(error => console.error("Error al obtener datos:", error));



function iniciarMap(data) {
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: { lat: -12.0463731, lng: -77.042754 }
    });

    let markers = [];

    if (data && Array.isArray(data)) {
        // Crear marcadores solo para establecimientos de salud al inicio
        data.filter(item => item.type === 'health_center').forEach(healthCenter => {
            const healthCenterMarker = createHealthCenterMarker(healthCenter);
            markers.push(healthCenterMarker);
        });

        // Mostrar los marcadores en el mapa
        markers.forEach(marker => marker.setMap(map));

        // Centrar el mapa en el primer marcador si hay marcadores disponibles
        if (markers.length > 0) {
            map.panTo(markers[0].getPosition());
        }
    }


    function createHealthCenterMarker(healthCenter) {
        const position = { lat: healthCenter.latitud, lng: healthCenter.longitud };

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: healthCenter.nombre || 'Centro de Salud',
            icon: {
                path: google.maps.SymbolPath.SQUARE,
                fillColor: 'red',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 1,
                scale: 10
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<strong>${healthCenter.nombre || 'Centro de Salud'}</strong><br>Latitud: ${healthCenter.latitud}<br>Longitud: ${healthCenter.longitud}`
        });

        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });

        return marker;
    }

    function createPoliceStationMarker(station) {
        const position = { lat: parseFloat(station.latitud), lng: parseFloat(station.longitud) };

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: station.nombre || 'Estación de Policía',
            icon: {
                path: "M-0.7735 6l3.2815-3.3045-0.703-0.703-2.578 2.6015-1.0315-1.0545-0.703 0.703zM0 0q1.453 0 2.4725 1.0195t1.0195 2.4725q0 0.7265-0.3635 1.664t-0.879 1.758-1.0195 1.535-0.8555 1.1365l-0.375 0.3985q-0.1405-0.164-0.375-0.4335t-0.844-1.078-1.0665-1.5705-0.832-1.7225-0.375-1.6875q0-1.453 1.0195-2.4725t2.4725-1.0195z",
                fillColor: 'orange',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 1,
                scale: 2
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<strong>${station.nombre || 'Estación de Policía'}</strong><br>#Efectivos policiales: ${station.inf110_tot}<br>`
        });

        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });

        return marker;
    }

    function createMarketMarker(market) {
        const position = { lat: parseFloat(market.latitud), lng: parseFloat(market.longitud) };

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: market.nombre || 'Mercado',
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: 'green',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 1,
                scale: 8
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<strong>${market.nombre || 'Mercado'}</strong><br>Latitud: ${market.latitud}<br>Longitud: ${market.longitud}`
        });

        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });

        return marker;
    }

    function createAeroportMarker(aeroport) {
        const position = { lat: parseFloat(aeroport.latitud), lng: parseFloat(aeroport.longitud) };

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: aeroport.nombre || 'Aeropuerto',
            icon: {
                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                fillColor: 'blue',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 1,
                scale: 5
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<strong>${aeroport.nombre || 'Aeropuerto'}</strong><br>Latitud: ${aeroport.latitud}<br>Longitud: ${aeroport.longitud}`
        });

        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });

        return marker;
    }


    function mostrarLeyendas(filteredData) {
        const healthCenter = Array.isArray(filteredData) && filteredData.length > 0 ? filteredData[0] : null;
        const hasWaterService = healthCenter.service_water && healthCenter.service_water.length > 0;
        const hasLightService = healthCenter.service_ligth && healthCenter.service_ligth.length > 0;

        document.getElementById('luzInfo').innerText = `LUZ: ${hasLightService ? 'Sí' : 'No'}`;
        document.getElementById('aguaInfo').innerText = `AGUA: ${hasWaterService ? 'Sí' : 'No'}`;

        if (healthCenter) {

            const profesionesSummary = {};

        if (healthCenter.health_center_professional_info && Array.isArray(healthCenter.health_center_professional_info)) {
            healthCenter.health_center_professional_info.forEach(profesional => {
                const profesion = profesional.profesion;
                const nProfActual = profesional.n_prof;

                if (profesionesSummary[profesion]) {
                    profesionesSummary[profesion] += nProfActual;
                } else {
                    profesionesSummary[profesion] = nProfActual;
                }
            });
        }

        let profesionesInfo = '<strong>Profesionales:</strong><br>';
        for (const profesion in profesionesSummary) {
            profesionesInfo += `${profesion}: ${profesionesSummary[profesion]}<br>`;
        }

        document.getElementById('leyendaProfesionales').innerHTML = profesionesInfo;

            document.getElementById('zona').innerText = `${healthCenter.departamento} - ${healthCenter.provincia} - ${healthCenter.distrito}`;

            if (healthCenter.aeroports && healthCenter.aeroports.length > 0) {
                const primerAeropuerto = healthCenter.aeroports[0];
                document.getElementById('aeropuerto').innerText = `Aeropuerto: ${primerAeropuerto.nombre} - ${primerAeropuerto.lugar} `;
            } else {
                document.getElementById('aeropuerto').innerText = `Aeropuerto: No disponible`;
            }

            document.getElementById('healthCenterName').innerText = `Nombre del centro de salud: ${healthCenter.nombre}`;
            document.getElementById('numPoliceStations').innerText = `Número de estaciones de policía: ${healthCenter.police_stations.length}`;

            if (healthCenter.markets && healthCenter.markets.length) {
                document.getElementById('numMarkets').innerText = `Número de mercados: ${healthCenter.markets.length}`;
            } else {
                document.getElementById('numMarkets').innerText = `Número de mercados: No disponible`;
            }

            const uniqueNetworks = new Set();

            if (healthCenter.mobile_networks && Array.isArray(healthCenter.mobile_networks)) {
                healthCenter.mobile_networks.forEach(network => {
                    uniqueNetworks.add(network.nombre);
                });
            }

            document.getElementById('mobileNetworks').innerHTML = '<strong>Operadores Disponibles:</strong><br>';

            uniqueNetworks.forEach(network => {
                document.getElementById('mobileNetworks').innerHTML += `${network}<br>`;
            });
        }
    }


    function addMarkers(data) {
        markers.forEach(marker => marker.setMap(null));
        markers = [];

        const selectedHealthCenter = $('#centros_salud').val();

        if (data) {
            data.forEach(item => {
                if (item.type === 'health_center') {
                    const healthCenterMarker = createHealthCenterMarker(item);
                    markers.push(healthCenterMarker);

                    if (item.type === 'health_center' && item.markets && item.markets.length > 0) {
                        item.markets.forEach(market => {
                            const marketMarker = createMarketMarker(market);
                            markers.push(marketMarker);
                        });
                    }

                    if (item.type === 'health_center' && item.police_stations && item.police_stations.length > 0) {
                        item.police_stations.forEach(station => {
                            const policeStationMarker = createPoliceStationMarker(station);
                            markers.push(policeStationMarker);
                        });
                    }
                    if (item.type === 'health_center' && item.aeroports && item.aeroports.length > 0) {
                        item.aeroports.forEach(aeroport => {
                            const AeroportMarket = createAeroportMarker(aeroport);
                            markers.push(AeroportMarket);
                        });
                    }
                }
            });
        }

        markers.forEach(marker => marker.setMap(map));

        if (markers.length > 0) {
            map.panTo(markers[0].getPosition());
        }
    }




    console.log("Antes de addMarkers en iniciarMap");
    addMarkers(data);

    mostrarLeyendas(data)

}



function realizarBusqueda() {
    const selectedCodigoUnico = $('#centros_salud').val();
    const detailsUrl = baseDetailsUrl + selectedCodigoUnico;

    fetch(detailsUrl)
        .then(response => response.json())
        .then(details => {
            const combinedData = [{
                type: 'health_center',
                nombre: details.health_center.nombre_del_establecimiento,
                departamento: details.health_center.departamento,
                provincia: details.health_center.provincia,
                distrito: details.health_center.distrito,
                latitud: parseFloat(details.health_center.lat),
                longitud: parseFloat(details.health_center.lon),

                police_stations: details.police_stations.map(station => ({
                    type: 'police_station',
                    nombre: station.nombredi,
                    latitud: parseFloat(station.gpslatitud_inf),
                    longitud: parseFloat(station.gpslongitud_inf),
                    inf110_tot: station.inf110_tot

                })),
                markets: details.markets.map(market => ({
                    type: 'market',
                    nombre: market["nombre del mercado"],
                    latitud: parseFloat(market.gps_lat),
                    longitud: parseFloat(market.gps_lon),
                })),
                mobile_networks: details.mobile_network.map(mobile_network => ({
                    type: 'mobile_network',
                    nombre: mobile_network["empresa_operadora"]
                })),
                aeroports: details.aeroports.map(aeroport => ({
                    type: 'aeroport',
                    nombre: aeroport.nombre,
                    latitud: parseFloat(aeroport.latitud),
                    longitud: parseFloat(aeroport.longitud),
                    lugar: aeroport.provincia
                })),
                health_center_professional_info: details.health_center_professional_info.map(profesionnal => ({
                    type: 'profesionnal',
                    profesion: profesionnal.profesion,
                    n_prof: profesionnal.n_prof
                })),
                service_water: details.service_water.map(service_water => ({
                    type: 'service_water',
                    profesion: service_water.codigo
                })),
                service_ligth: details.service_ligth.map(service_ligth => ({
                    type: 'service_ligth',
                    profesion: service_ligth.codigo
                })),
            }];

            iniciarMap(combinedData);

        })
        .catch(error => console.error("Error al obtener detalles del establecimiento:", error));
}
