@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <style>
        #map {
            width: 100%;
        }

        .marker {
            background-image: url('https://images.ctfassets.net/3prze68gbwl1/assetglossary-17su9wok1ui0z7w/c4c4bdcdf0d0f86447d3efc450d1d081/map-marker.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">Work Schedules</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default text-600 btn-sm " href="{{ route('shifttype.create') }}"><span
                            class="fas fa-plus fs--2 me-1"></span>Add Work Schedule</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <tbody>
                    <form action="" method="post">
                        @csrf
                        <tr>
                            <td>
                                <label for="">Site Name</label>
                                <input class="form-control" type="text" name="lat">
                            </td>
                            <td>
                                <label for="">Latitude</label>
                                <input class="form-control" type="text" name="lat">
                            </td>
                            <td>
                                <label for="">Longitude</label>
                                <input class="form-control" type="text" name="long">
                            </td>
                            <td>
                                <label for="">Radius</label>
                                <input class="form-control" type="text" name="radius">
                            </td>
                            <td class="align-middle">
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('are you sure?')"><span
                                        class="fas fa-plus-circle fs--2 me-1"></span>Add</button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
        <div class="p-3">
            <div id='map' style='width: 100%; height: 300px;'></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlmcWk0MzIwIiwiYSI6ImNsbWFha3k4eTBva3ozZ3M2bHpucXVob2sifQ.iT6c1uBOTK1Wc90a8nSXNA';

        const geojson = {
            'type': 'FeatureCollection',
            'features': [{
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [-77.032, 38.913]
                    },
                    'properties': {
                        'title': 'Mapbox',
                        'description': 'Washington, D.C.'
                    }
                },
                {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [-122.414, 37.776]
                    },
                    'properties': {
                        'title': 'Mapbox',
                        'description': 'San Francisco, California'
                    }
                }
            ]
        };

        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [-74.5, 40], // starting position [lng, lat]
            zoom: 1, // starting zoom
        });

        // add markers to map
        for (const feature of geojson.features) {
            // create a HTML element for each feature
            const el = document.createElement('div');
            el.className = 'marker';

            // make a marker for each feature and add it to the map
            new mapboxgl.Marker(el)
                .setLngLat(feature.geometry.coordinates)
                .setPopup(
                    new mapboxgl.Popup({
                        offset: 25
                    }) // add popups
                    .setHTML(
                        `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
                    )
                )
                .addTo(map);
        }
    </script>
@endsection
