<!DOCTYPE HTML>
<html>
<head>
<title>OpenLayers Simplest Example</title>
</head>
<body>
<div id="Map" style="height:250px"></div>
<script src="{{ asset('openmap/OpenLayers.js') }}"></script>
<script>
    var lat            = 47.35387;
    var lon            = 8.43609;
    var zoom           = 18;

    var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
    var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
    var position       = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);

    map = new OpenLayers.Map("Map");
    var mapnik         = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
    markers.addMarker(new OpenLayers.Marker(position));

    map.setCenter(position, zoom);
</script>
</body>
</html>