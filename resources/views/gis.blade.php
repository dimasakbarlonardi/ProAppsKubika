<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <style>
        #map{
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <h1>GIS</h1>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlmcWk0MzIwIiwiYSI6ImNsbWFhbzhwODB1N2ozZG81bTJpZWJwamoifQ.1MRlqW9smYuN1wIieOEg2w';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [106.89705084553827, -6.147124632047256], // starting position [lng, lat]
            markers: [106.89705084553827, -6.147124632047256],
            zoom: 18, // starting zoom
        });
    </script>

</body>

</html>
