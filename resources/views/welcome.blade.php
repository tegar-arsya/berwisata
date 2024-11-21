<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Local Tourism</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Leaflet Maps -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS and Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .leaflet-routing-container {
            display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-poppins text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar with Improved Styling -->
        @include('components.navbar')

        <!-- Main Content Container -->
        <main class="flex-grow container mx-auto px-6 py-8">
            @include('components.carousel')
            <!-- Category Filter Section with Enhanced Design -->
            <section class="mb-10 mt-20" id="filter-section">
                <form action="{{ route('home') }}" method="GET" class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6">
                    <div class="flex space-x-4">
                        <div class="flex-grow relative">
                            <button id="dropdown-button"
                                    class="w-full text-left py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg
                                           flex justify-between items-center
                                           hover:bg-gray-200 transition duration-300">
                                <span>
                                    {{ request('kategori_id') ? $kategoris->find(request('kategori_id'))->nama_kategori : 'All Categories' }}
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown Content (would be dynamically handled with JavaScript) -->
                        </div>
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg
                                       hover:bg-blue-700 transition duration-300
                                       flex items-center space-x-2">
                            <span>Filter</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </section>

            <!-- Tourism Cards Grid -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($wisatas as $wisata)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg
                                hover:shadow-2xl transform hover:-translate-y-3
                                transition duration-500 ease-in-out">
                        <div class="relative">
                            <img src="{{ asset('gambar-wisata/' . $wisata->images->first()->image_path[0]) }}"
                                 alt="{{ $wisata->nama_wisata }}"
                                 class="w-full h-64 object-cover">
                                 @php
                                // Define an array of distinct background colors
                                $tagColors = [
                                    'bg-blue-500',
                                    'bg-green-500',
                                    'bg-purple-500',
                                    'bg-pink-500',
                                    'bg-indigo-500',
                                    'bg-yellow-500',
                                    'bg-red-500',
                                    'bg-teal-500'
                                ];
                            @endphp
                            <div class="absolute top-4 right-4 flex space-x-2">
                                @foreach($wisata->tags as $index => $tag)
                                <span class="{{ $tagColors[$index % count($tagColors)] }}
                                text-white text-xs px-2 py-1 rounded-full
                                shadow-sm transition duration-300
                                hover:scale-105">
                                    {{ $tag->nama_tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-3 text-gray-800">
                                {{ $wisata->nama_wisata }}
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $wisata->deskripsi }}
                            </p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">
                                        {{ number_format($wisata->reviews->avg('rating'), 1) }}
                                    </span>
                                </div>
                                <a href="{{ route('wisata.detail', $wisata->id) }}"
                                   class="text-blue-600 hover:text-blue-800
                                          flex items-center space-x-2
                                          transition duration-300">
                                    <span>Details</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

            <!-- Map Section with Enhanced Design -->
            <section class="mt-16 bg-white rounded-2xl shadow-lg overflow-hidden" id="map-section">
                <div class="p-6 bg-blue-50">
                    <h2 class="text-3xl font-bold text-blue-800 mb-4">Tourism Map</h2>
                </div>
                <div id="leaflet-map" style="height: 500px;"></div>
            </section>
        </main>

        <!-- Footer with Modern Design -->
        @include('components.footer')
    </div>

    <!-- Leaflet Map Script (Similar to original script) -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        var map = L.map('leaflet-map').setView([-6.8959402, 109.6333037], 10);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // User's current location marker and circle
        var userLocationMarker = null;
        var userAccuracyCircle = null;

        // Routing control (initially null)
        var routingControl = null;

        // Custom icons
        var userIcon = L.divIcon({
            className: 'custom-user-location',
            html: `
                <div style="
                    width: 30px;
                    height: 30px;
                    background-color: blue;
                    border-radius: 50%;
                    border: 3px solid white;
                    box-shadow: 0 0 10px rgba(0,0,255,0.5);
                "></div>
            `,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        var destinationIcon = L.divIcon({
            className: 'custom-destination-icon',
            html: `
                <div style="
                    width: 30px;
                    height: 45px;
                    background-color: red;
                    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                    border: 2px solid white;
                    box-shadow: 0 0 10px rgba(255,0,0,0.5);
                "></div>
            `,
            iconSize: [30, 45],
            iconAnchor: [15, 45]
        });

        // Function to add destination markers
        function addDestinationMarkers() {
            var wisatas = @json($wisatas);

            wisatas.forEach(function(wisata) {
                if (wisata.latitude && wisata.longitude) {
                    var marker = L.marker([wisata.latitude, wisata.longitude], {
                        icon: destinationIcon
                    })
                    .addTo(map)
                    .bindPopup(`
                        <div class="text-center">
                            <h3 class="font-bold text-lg">${wisata.nama_wisata}</h3>
                            <p class="text-sm text-gray-600 mb-2">${wisata.deskripsi}</p>
                            <button onclick="calculateRoute(${wisata.latitude}, ${wisata.longitude})"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Route to Destination
                            </button>
                        </div>
                    `);
                }
            });
        }

        // Function to get user's location
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        var accuracy = position.coords.accuracy;

                        // Remove existing markers if they exist
                        if (userLocationMarker) {
                            map.removeLayer(userLocationMarker);
                        }
                        if (userAccuracyCircle) {
                            map.removeLayer(userAccuracyCircle);
                        }

                        // Add user location marker
                        userLocationMarker = L.marker([lat, lng], {
                            icon: userIcon
                        }).addTo(map).bindPopup("Your Current Location");

                        // Add accuracy circle
                        userAccuracyCircle = L.circle([lat, lng], {
                            color: 'blue',
                            fillColor: '#30a5ff',
                            fillOpacity: 0.2,
                            radius: accuracy
                        }).addTo(map);

                        // Center map on user's location
                        map.setView([lat, lng], 12);

                        // Store user location for routing
                        window.userLocation = [lat, lng];
                    },
                    function(error) {
                        console.error("Error getting location: ", error);
                        alert("Error getting location: " + error.message);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Global function to calculate route
        window.calculateRoute = function(destLat, destLng) {
            // Remove existing routing control if it exists
            if (routingControl) {
                map.removeControl(routingControl);
            }

            // Check if user location is available
            if (window.userLocation) {
                // Create routing control
                routingControl = L.Routing.control({
                    waypoints: [
                        L.latLng(window.userLocation[0], window.userLocation[1]),
                        L.latLng(destLat, destLng)
                    ],
                    routeWhileDragging: true,
                    geocoder: L.Control.Geocoder.nominatim(),
                    lineOptions: {
                        styles: [{
                            color: 'blue',
                            opacity: 0.7,
                            weight: 5
                        }]
                    },
                    addWaypoints: false,
                    draggableWaypoints: false,
                    fitSelectedRoutes: true,
                    showAlternatives: true
                }).addTo(map);
            } else {
                alert("Please get your location first by clicking the locate button!");
            }
        }

        // Add a locate me button
        L.Control.LocateMe = L.Control.extend({
            options: {
                position: 'topright'
            },
            onAdd: function(map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                var button = L.DomUtil.create('a', 'leaflet-control-locate', container);
                button.href = '#';
                button.title = 'My Location';
                button.innerHTML = '🌍';

                L.DomEvent.on(button, 'click', function(e) {
                    L.DomEvent.stopPropagation(e);
                    getUserLocation();
                });

                return container;
            }
        });

        L.control.locateMe = function(opts) {
            return new L.Control.LocateMe(opts);
        }

        // Add controls to the map
        map.addControl(L.control.locateMe());

        // Add destination markers
        addDestinationMarkers();
    });
</script>
</body>
</html>
