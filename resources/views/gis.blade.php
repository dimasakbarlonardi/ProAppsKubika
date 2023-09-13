<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Variable label placement</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
        }

        .marker {
            background-image: url('https://cdn4.iconfinder.com/data/icons/small-n-flat/24/map-marker-512.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .container {
            background: black;
            position: relative;
            height: 100vh;
            z-index: 0;
            align-items: center;
            justify-items: center;
        }

        .button {
            position: absolute;
            display: inline-block;
            border-radius: 4px;
            background-color: #009ada;
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-family: 'Raleway', sans-serif;
            text-transform: uppercase;
            font-size: 26px;
            padding: 9px;
            width: 200px;
            transition: all 0.5s;
            cursor: pointer;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
            bottom: 0;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="map" class="container">
        <button class="button margin-auto" id="absence-button">Absence</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var lat = '{{ $site->lat }}';
        var long = '{{ $site->long }}';
        var my_lat = 0;
        var my_long = 0;
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlmcWk0MzIwIiwiYSI6ImNsbWFha3k4eTBva3ozZ3M2bHpucXVob2sifQ.iT6c1uBOTK1Wc90a8nSXNA';

        const map = new mapboxgl.Map({
            container: 'map',
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            style: 'mapbox://styles/mapbox/light-v11',
            zoom: 12.15
        });

        $('document').ready(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }

            function showPosition(position) {
                my_lat = position.coords.latitude;
                my_long = position.coords.longitude;
                if (my_lat != 0 && my_long != 0) {
                    addMarker(my_lat, my_long);
                }
            };

            function addMarker(my_lat, my_long) {
                my_lat = -6.140036867232763;
                my_long = 106.92380431852365;

                map.setCenter([my_long, my_lat]);

                const places = {
                    'type': 'FeatureCollection',
                    'features': [{
                            'type': 'Feature',
                            'properties': {
                                'description': "Office",
                                'icon': 'theatre'
                            },
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [long, lat]
                            }
                        },
                        {
                            'type': 'Feature',
                            'properties': {
                                'description': 'Your location',
                                'icon': 'airport'
                            },
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [my_long, my_lat]
                            }
                        }
                    ]
                };

                map.addSource('places', {
                    'type': 'geojson',
                    'data': places
                });

                map.addLayer({
                    'id': 'poi-labels',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {
                        'text-field': ['get', 'description'],
                        'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                        'text-radial-offset': 0.5,
                        'text-justify': 'auto',
                        'icon-image': ['get', 'icon']
                    }
                });

                map.rotateTo(180, {
                    duration: 100000
                });
            }

            $('#absence-button').on('click', function() {
                my_lat = -6.140036867232763;
                my_long = 106.92380431852365;

                console.log(my_lat, my_long);

                if (my_lat != 0 && my_long != 0) {
                    $.ajax({
                        url: '/absence',
                        type: 'POST',
                        data: {
                            "my_lat": my_lat,
                            "my_long": my_long
                        },
                        success: function(resp) {
                            alert(resp.status);
                            console.log(resp.status);
                        }
                    })
                } else {
                    alert('Location not found');
                }
            })
        });
    </script>

</body>

</html>
