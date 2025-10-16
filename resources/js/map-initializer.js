document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    const ukraineCenterLat = 48.3794;
    const ukraineCenterLon = 31.1656;
    const initialZoom = 6;

    const bounds = [
        [44.0, 22.0],
        [52.5, 41.5]
    ];

    const map = L.map('map', {
        maxBounds: bounds,
        maxBoundsViscosity: 1.0
    }).setView([ukraineCenterLat, ukraineCenterLon], initialZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        minZoom: 5,
        maxZoom: 18
    }).addTo(map);

    fetch('/api/map/objects')
        .then(response => response.json())
        .then(objects => {
            const markers = [];
            objects.forEach(obj => {
                const icon = getMarkerIcon(obj.type, obj.status);
                const popupContent = `
                    <div style="font-size: 14px;">
                        <h4 style="font-weight: bold; margin-bottom: 5px; color: ${icon.options.html.includes('red') ? '#dc2626' : '#1e40af'};">${obj.name} (${obj.type})</h4>
                        <p>Status: <strong>${obj.status}</strong></p>
                        <p>Description: ${obj.description ? obj.description.substring(0, 50) + '...' : 'N/A'}</p>
                        <p class="text-xs mt-2">Lat: ${obj.latitude}, Lon: ${obj.longitude}</p>
                    </div>
                `;

                const marker = L.marker([obj.latitude, obj.longitude], { icon: icon })
                    .bindPopup(popupContent);

                markers.push(marker);
            });
        })
        .catch(error => console.error('Error fetching map data:', error));

    const getMarkerIcon = (type, status) => {
        let color = '#3388ff';
        if (status === 'Error') {
            color = '#dc2626';
        } else if (status === 'Inactive') {
            color = '#535353';
        } else if (status === 'Maintenance') {
            color = '#f59e0b';
        } else if (status === 'Active') {
            color = '#84cc16';
        }

        return L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: ${color}; 
                               width: 15px; height: 15px; 
                               border-radius: 50%; border: 3px solid white;"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });
    };
});