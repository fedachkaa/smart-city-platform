let map;
let routePolyline;
let markers = [];
let allowToSetMarkers = true;
let selectedObjects = [];
let generatedRoute = null;

window.initMap = function() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: mapCenter,
        zoom: 12,
        mapId: 'createRoteMap'
    });

    const bounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(cityBounds[0][0], cityBounds[0][1]),
        new google.maps.LatLng(cityBounds[1][0], cityBounds[1][1])
    );
    map.setOptions({ restriction: { latLngBounds: bounds, strictBounds: false } });

    map.addListener('click', (e) => {
        if (allowToSetMarkers) {
            const latLng = e.latLng;
            document.getElementById('start_address').value = latLng.lat() + ',' + latLng.lng();
            clearMarkers();

            reverseGeocode(latLng, (address) => {
                document.getElementById('start_address_text').value = address;
                addMarker(latLng, 'Start Point', address);
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('generate-route').addEventListener('click', async (e) => {
        e.preventDefault();
        selectedObjects = Array.from(document.querySelectorAll('.js-object-checkbox:checked')).map(el => el.value);
        if (selectedObjects.length === 0) {
            alert('Select at least 1 object!');
            return;
        }
        if (selectedObjects.length > 5) {
            alert('Select maximum 5 objects!');
            return;
        }

        const start = document.getElementById('start_address').value;
        if (!start) {
            alert('Set a start point!');
            return;
        }

        const response = await fetch('/dashboard/routes/preview', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                object_ids: selectedObjects,
                start_point: start
            })
        });
        const data = await response.json();
        if (data.route) {
            generatedRoute = data.route;
            renderRoute(data.route);
        }
        else {
            alert('Failed to generate route');
        }
    });

    document.getElementById('saveRouteBtn').addEventListener('click', async (e) => {
        e.preventDefault();
        if (!generatedRoute) return alert('No route to save');

        const response = await fetch('/dashboard/routes', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name: document.getElementById('name').value,
                start_time: document.getElementById('start_time').value,
                start_point: document.getElementById('start_address').value,
                start_point_address: document.getElementById('start_address_text').value,
                object_ids: selectedObjects,
                route_polyline: generatedRoute.polyline,
                route_legs: generatedRoute.legs,
                optimized_order: generatedRoute.optimized_order
            })
        });

        const data = await response.json();
        if (data.success) {
            document.location.href = '/dashboard/routes';
        } else {
            alert('Failed to save route');
        }
    });

});

function addMarker(latLng, title = '', address = '') {
    const marker = new google.maps.marker.AdvancedMarkerElement({
        position: latLng,
        map,
        title: title,
    });

    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div>
                <strong>${title}</strong><br>
                ${address}
            </div>
        `
    });

    marker.addListener('click', () => {
        infoWindow.open({
            anchor: marker,
            map,
        });
    });

    markers.push(marker);
}

function clearMarkers() {
    markers.forEach(m => m.setMap(null));
    markers = [];
}

function renderRoute(route) {
    clearMarkers();
    allowToSetMarkers = false;

    if (!route.polyline) {
        console.error('No polyline found in route');
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

    route.legs.forEach((leg, index) => {
        addMarker(
            leg.end_location,
            route.optimized_order.includes(index) ? `Stop ${index + 1}` : 'Start',
            leg.end_address || ''
        );
    });

    const bounds = new google.maps.LatLngBounds();
    decodedPath.forEach(p => bounds.extend(p));
    map.fitBounds(bounds);
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