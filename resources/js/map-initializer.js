document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    const { city } = window.appConfig || {};
    const lat = city?.latitude ?? 50.4501;
    const lon = city?.longitude ?? 30.5234;
    const initialZoom = 11;

    const map = L.map('map', {
        maxBounds: [
            [44.0, 22.0],
            [52.5, 41.5]
        ],
        maxBoundsViscosity: 1.0
    }).setView([lat, lon], initialZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        minZoom: 5,
        maxZoom: 18
    }).addTo(map);

    let heatLayer = null;

    fetch('/api/map/objects')
        .then(response => response.json())
        .then(objects => {
            const heatData = [];

            objects.forEach(obj => {
                if (obj.latitude && obj.longitude) {
                    heatData.push([obj.latitude, obj.longitude, 0.6]); // third = intensity
                }

                const icon = getMarkerIcon(obj.type, obj.status);
                const popupContent = `
                <div style="font-size: 14px;">
                    <h4 style="font-weight: bold; margin-bottom: 5px;">${obj.name} (${obj.type})</h4>
                    <p>Status: <strong>${obj.status}</strong></p>
                    <p>${obj.description ? obj.description.substring(0, 50) + '...' : 'N/A'}</p>
                </div>
            `;

                L.marker([obj.latitude, obj.longitude], { icon }).bindPopup(popupContent).addTo(map);
            });

            heatLayer = L.heatLayer(heatData, {
                radius: 20,
                blur: 15,
                maxZoom: 12,
            });
        });

    const toggle = document.getElementById('heatmap-toggle');

    toggle.addEventListener('change', function () {
        if (!heatLayer) return;
        if (toggle.checked) {
            map.addLayer(heatLayer);
        } else {
            map.removeLayer(heatLayer);
        }
    });

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