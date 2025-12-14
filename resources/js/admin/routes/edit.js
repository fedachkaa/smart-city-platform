let map, routePolyline, markers = [];

window.initMap = function() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapCenter,
        zoom: 12,
        mapId: 'viewRouteMap'
    });

    if (!savedRoute) {
        return console.warn('No route data available');
    }

    renderRoute(savedRoute);
}

function renderRoute(route) {
    if (!route.polyline) {
        console.error('No polyline in route');
        return;
    }

    const decodedPath = google.maps.geometry.encoding.decodePath(route.polyline);

    if (routePolyline) routePolyline.setMap(null);
    routePolyline = new google.maps.Polyline({
        path: decodedPath,
        strokeColor: '#06b6d4',
        strokeOpacity: 0.8,
        strokeWeight: 5,
        map
    });

    const bounds = new google.maps.LatLngBounds();

    route.legs.forEach((leg, index) => {
        const lat = leg.endLocation.latLng.latitude;
        const lng = leg.endLocation.latLng.longitude;

        reverseGeocode({ lat, lng }, (address) => {
            addMarker(
                { lat, lng },
                route.legs.length - 1 === index ?  'Start/Finish' : `Stop ${index + 1}`,
                address
            );
        });

        bounds.extend(new google.maps.LatLng(lat, lng));
    });

    decodedPath.forEach(p => bounds.extend(p));
    map.fitBounds(bounds);
}

function addMarker(latLng, title = '', address = '') {
    const marker = new google.maps.marker.AdvancedMarkerElement({
        position: latLng,
        map,
        title: title,
    });

    const infoWindow = new google.maps.InfoWindow({
        content: `<div><strong>${title}</strong><br>${address}</div>`
    });

    marker.addListener('click', () => {
        infoWindow.open({ anchor: marker, map });
    });

    markers.push(marker);
}

function reverseGeocode(latLng, callback) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: latLng }, (results, status) => {
        if (status === "OK" && results[0]) {
            callback(results[0].formatted_address);
        } else {
            callback(`${latLng.lat().toFixed(6)}, ${latLng.lng().toFixed(6)}`);
        }
    });
}