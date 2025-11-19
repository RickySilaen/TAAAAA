/**
 * Maps Service with Leaflet
 * 
 * Features:
 * - Interactive maps
 * - Land location markers
 * - Aid distribution visualization
 * - Harvest heatmap
 * - Drawing tools
 * - Geolocation
 */

class MapsService {
    constructor(options = {}) {
        this.container = options.container || 'map';
        this.center = options.center || [-2.5489, 118.0149]; // Indonesia center
        this.zoom = options.zoom || 5;
        this.markers = [];
        this.layers = {};
        this.map = null;
        
        this.init();
    }

    /**
     * Initialize map
     */
    init() {
        // Create map
        this.map = L.map(this.container).setView(this.center, this.zoom);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(this.map);

        // Add layer control
        this.setupLayerControl();

        // Add drawing tools
        this.setupDrawingTools();

        // Add locate control
        this.setupLocateControl();
    }

    /**
     * Setup layer control
     */
    setupLayerControl() {
        // Base layers
        const baseLayers = {
            'OpenStreetMap': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
            'Satellite': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'),
            'Terrain': L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png'),
        };

        // Overlay layers
        this.layers = {
            'farmers': L.layerGroup().addTo(this.map),
            'aid': L.layerGroup().addTo(this.map),
            'harvest': L.layerGroup().addTo(this.map),
        };

        const overlays = {
            'Lokasi Petani': this.layers.farmers,
            'Distribusi Bantuan': this.layers.aid,
            'Hasil Panen': this.layers.harvest,
        };

        L.control.layers(baseLayers, overlays).addTo(this.map);
    }

    /**
     * Setup drawing tools
     */
    setupDrawingTools() {
        const drawnItems = new L.FeatureGroup();
        this.map.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                marker: true,
                circle: true,
                rectangle: true,
                polyline: true,
                circlemarker: false,
            }
        });
        this.map.addControl(drawControl);

        // Draw created event
        this.map.on(L.Draw.Event.CREATED, (e) => {
            const layer = e.layer;
            drawnItems.addLayer(layer);
            
            // Get area or length
            if (layer instanceof L.Polygon || layer instanceof L.Rectangle) {
                const area = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
                const hectares = (area / 10000).toFixed(2);
                layer.bindPopup(`Luas: ${hectares} hektar`).openPopup();
            }
        });
    }

    /**
     * Setup locate control
     */
    setupLocateControl() {
        L.control.locate({
            position: 'topright',
            strings: {
                title: 'Lokasi Saya'
            },
            locateOptions: {
                enableHighAccuracy: true
            }
        }).addTo(this.map);
    }

    /**
     * Add farmer location marker
     */
    addFarmerMarker(data) {
        const icon = L.divIcon({
            html: `<div class="marker-icon farmer"><i class="bi bi-person-fill"></i></div>`,
            className: 'custom-marker',
            iconSize: [40, 40],
        });

        const marker = L.marker([data.lat, data.lng], { icon })
            .bindPopup(this.createFarmerPopup(data))
            .addTo(this.layers.farmers);

        this.markers.push({ type: 'farmer', id: data.id, marker });
        return marker;
    }

    /**
     * Create farmer popup content
     */
    createFarmerPopup(data) {
        return `
            <div class="map-popup">
                <h6>${data.nama}</h6>
                <div class="popup-info">
                    <div><strong>Desa:</strong> ${data.desa}</div>
                    <div><strong>Luas Lahan:</strong> ${data.luas_lahan} ha</div>
                    <div><strong>Jenis Tanaman:</strong> ${data.jenis_tanaman || '-'}</div>
                </div>
                <a href="/petani/${data.id}" class="btn btn-sm btn-primary mt-2">
                    Lihat Detail
                </a>
            </div>
        `;
    }

    /**
     * Add aid distribution marker
     */
    addAidMarker(data) {
        const icon = L.divIcon({
            html: `<div class="marker-icon aid"><i class="bi bi-gift-fill"></i></div>`,
            className: 'custom-marker',
            iconSize: [40, 40],
        });

        const marker = L.marker([data.lat, data.lng], { icon })
            .bindPopup(this.createAidPopup(data))
            .addTo(this.layers.aid);

        this.markers.push({ type: 'aid', id: data.id, marker });
        return marker;
    }

    /**
     * Create aid popup content
     */
    createAidPopup(data) {
        const statusColors = {
            pending: 'warning',
            approved: 'success',
            rejected: 'danger',
            delivered: 'info',
        };

        return `
            <div class="map-popup">
                <h6>Bantuan ${data.jenis_bantuan}</h6>
                <div class="popup-info">
                    <div><strong>Petani:</strong> ${data.petani_nama}</div>
                    <div><strong>Jumlah:</strong> ${data.jumlah}</div>
                    <div>
                        <strong>Status:</strong> 
                        <span class="badge bg-${statusColors[data.status]}">
                            ${data.status}
                        </span>
                    </div>
                    <div><strong>Tanggal:</strong> ${this.formatDate(data.created_at)}</div>
                </div>
                <a href="/bantuan/${data.id}" class="btn btn-sm btn-primary mt-2">
                    Lihat Detail
                </a>
            </div>
        `;
    }

    /**
     * Add harvest heatmap
     */
    addHarvestHeatmap(data) {
        // Prepare heat data
        const heatData = data.map(item => [
            item.lat,
            item.lng,
            item.hasil_panen / 1000 // Normalize
        ]);

        // Create heatmap layer
        const heat = L.heatLayer(heatData, {
            radius: 25,
            blur: 15,
            maxZoom: 17,
            max: 10,
            gradient: {
                0.0: 'blue',
                0.5: 'lime',
                0.7: 'yellow',
                1.0: 'red'
            }
        }).addTo(this.layers.harvest);

        // Add legend
        this.addHeatmapLegend();
    }

    /**
     * Add heatmap legend
     */
    addHeatmapLegend() {
        const legend = L.control({ position: 'bottomright' });

        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'heatmap-legend');
            div.innerHTML = `
                <h6>Hasil Panen (kg)</h6>
                <div class="legend-item"><span style="background: red"></span> > 10,000</div>
                <div class="legend-item"><span style="background: yellow"></span> 5,000 - 10,000</div>
                <div class="legend-item"><span style="background: lime"></span> 1,000 - 5,000</div>
                <div class="legend-item"><span style="background: blue"></span> < 1,000</div>
            `;
            return div;
        };

        legend.addTo(this.map);
    }

    /**
     * Add cluster markers for large datasets
     */
    addClusterMarkers(data, type) {
        const markers = L.markerClusterGroup({
            iconCreateFunction: (cluster) => {
                const count = cluster.getChildCount();
                let size = 'small';
                if (count > 50) size = 'large';
                else if (count > 10) size = 'medium';

                return L.divIcon({
                    html: `<div class="cluster-icon ${size}">${count}</div>`,
                    className: 'marker-cluster',
                    iconSize: L.point(40, 40),
                });
            }
        });

        data.forEach(item => {
            const marker = type === 'farmer' 
                ? this.createFarmerMarkerForCluster(item)
                : this.createAidMarkerForCluster(item);
            markers.addLayer(marker);
        });

        this.map.addLayer(markers);
    }

    /**
     * Create farmer marker for cluster
     */
    createFarmerMarkerForCluster(data) {
        const icon = L.divIcon({
            html: `<div class="marker-icon farmer"><i class="bi bi-person-fill"></i></div>`,
            className: 'custom-marker',
            iconSize: [40, 40],
        });

        return L.marker([data.lat, data.lng], { icon })
            .bindPopup(this.createFarmerPopup(data));
    }

    /**
     * Create aid marker for cluster
     */
    createAidMarkerForCluster(data) {
        const icon = L.divIcon({
            html: `<div class="marker-icon aid"><i class="bi bi-gift-fill"></i></div>`,
            className: 'custom-marker',
            iconSize: [40, 40],
        });

        return L.marker([data.lat, data.lng], { icon })
            .bindPopup(this.createAidPopup(data));
    }

    /**
     * Draw polygon for area selection
     */
    drawPolygon(coordinates, options = {}) {
        const polygon = L.polygon(coordinates, {
            color: options.color || '#3388ff',
            fillColor: options.fillColor || '#3388ff',
            fillOpacity: options.fillOpacity || 0.2,
            weight: options.weight || 2,
        }).addTo(this.map);

        if (options.popup) {
            polygon.bindPopup(options.popup);
        }

        this.map.fitBounds(polygon.getBounds());
        return polygon;
    }

    /**
     * Draw circle radius
     */
    drawCircle(center, radius, options = {}) {
        const circle = L.circle(center, {
            color: options.color || '#3388ff',
            fillColor: options.fillColor || '#3388ff',
            fillOpacity: options.fillOpacity || 0.2,
            radius: radius, // in meters
        }).addTo(this.map);

        if (options.popup) {
            circle.bindPopup(options.popup);
        }

        return circle;
    }

    /**
     * Get markers within bounds
     */
    getMarkersInBounds(bounds) {
        return this.markers.filter(({ marker }) => {
            return bounds.contains(marker.getLatLng());
        });
    }

    /**
     * Clear all markers
     */
    clearMarkers(type = null) {
        if (type) {
            this.layers[type].clearLayers();
            this.markers = this.markers.filter(m => m.type !== type);
        } else {
            Object.values(this.layers).forEach(layer => layer.clearLayers());
            this.markers = [];
        }
    }

    /**
     * Fit map to markers
     */
    fitToMarkers(type = null) {
        const markersToFit = type 
            ? this.markers.filter(m => m.type === type).map(m => m.marker)
            : this.markers.map(m => m.marker);

        if (markersToFit.length === 0) return;

        const group = L.featureGroup(markersToFit);
        this.map.fitBounds(group.getBounds().pad(0.1));
    }

    /**
     * Search location by address
     */
    async searchLocation(address) {
        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`
            );
            const data = await response.json();
            
            if (data.length > 0) {
                const { lat, lon } = data[0];
                this.map.setView([lat, lon], 15);
                return { lat, lon };
            }
            
            return null;
        } catch (error) {
            console.error('Location search error:', error);
            return null;
        }
    }

    /**
     * Format date
     */
    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('id-ID');
    }

    /**
     * Destroy map
     */
    destroy() {
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    }
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MapsService;
}
