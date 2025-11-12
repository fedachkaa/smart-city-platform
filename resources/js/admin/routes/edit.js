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

    routePolyline = new google.maps.Polyline({
        path: decodedPath,
        strokeColor: '#06b6d4',
        strokeOpacity: 0.8,
        strokeWeight: 5,
        map
    });

    const bounds = new google.maps.LatLngBounds();

    if (route.start_point && Array.isArray(route.start_point)) {
        addMarker({ lat: route.start_point.lat, lng: route.start_point.lng }, 'Start', 'Start Point');
        bounds.extend(new google.maps.LatLng(route.start_point.lat, route.start_point.lng));
    }

    if (route.legs && Array.isArray(route.legs)) {
        route.legs.forEach((leg, index) => {
            addMarker(
                leg.end_location,
                route.optimized_order.includes(index) ? `Stop ${index + 1}` : 'Start',
                leg.end_address || ''
            );
        });
    }

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