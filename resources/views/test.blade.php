<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<title>Add a marker</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.css' rel='stylesheet' />
<style>
            body { margin:0px; padding:0px; }
            #map { position:absolute; top:0px; bottom:0px; width:100%; }
        </style>
</head>
<body>
<style>
            /*Example 1, all the CSS is defined here and not in JS*/            
            #markerWithExternalCss {
                background-image: url("{{ asset('img/marker50px.png') }}"); 
                background-size: cover;
                width: 100px;
                height: 100px;
                cursor: pointer;
            }
            
            /*Example 2, most of the CSS is set by JS*/
            .marker {
                display: block;
                border: none;
                cursor: pointer;
                padding: 0;
            }

        </style>
<div id='map'></div>
<script>
            //Add your LocationIQ Maps Access Token here (not the API token!)
            ocationiqKey = 'pk.117b9918776737ca2eb077f1107dda05';
            //Define the map and configure the map's theme
            var map = new mapboxgl.Map({
                container: 'map',
                attributionControl: false, //need this to show a compact attribution icon (i) instead of the whole text
                style: 'https://tiles.locationiq.com/v2/streets/vector.json?key='+locationiqKey,
                zoom: 12,
                center: [-122.42, 37.779]
            });
                        
            //Marker can be style either while adding the marker using JS or separately using CSS

            //Here's an example where we use external CSS to specify background image, size, etc
            //https://www.mapbox.com/mapbox-gl-js/api#marker
            // first create DOM element for the marker
            var el = document.createElement('div');
            el.id = 'markerWithExternalCss';
            // finally, create the marker
            var markerWithExternalCss = new mapboxgl.Marker(el)
                .setLngLat([-122.444733, 37.767443])
                .addTo(map);

            //Here's an example where use set variables like backgroundImage in JS itself (the common params are specified in CSS '.marker'
            var el2 = document.createElement('div');
            el2.className = 'marker';
            el2.style.backgroundImage = 'url("{{ asset('img/marker50px.png') }}")';
            el2.style.width = '50px';
            el2.style.height = '50px';
            
            // add marker to map
            new mapboxgl.Marker(el2)
                .setLngLat([-122.4727000, 37.786258])
                .addTo(map);

        </script>
</body>
</html>