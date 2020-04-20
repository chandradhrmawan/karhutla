@extends('admin/admin')      

@section('content')

{{--  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
   Make sure you put this AFTER Leaflet's CSS
 <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script> --}}
 <script src="{{ asset('geojson_id.js') }}"></script>

   <style type="text/css">
   		#mapid { height: 500px; }
   </style>


<div class="row">
  <div class="col-md-12">

  	 <div id="mapid"></div>

  	 <script type="text/javascript">
  	 	var long = 113.9213257;
  	 	var lat  = -0.789275;
  	 	var zoom = 5;
  	 	var mymap = L.map('mapid').setView([lat, long], zoom);
  	 	var apikey = 'pk.eyJ1IjoiY2hhbmRyYWRhcm1hd2FuMTciLCJhIjoiY2s5OGp6MWxxMDJ6bDNtbW5ndWtpeTR1MiJ9.dOWewSSFZpkoosXlkf99Pg';
  	 	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
	    	maxZoom: 18,
		    id: 'mapbox/light-v9',
		    tileSize: 512,
		    zoomOffset: -1,
		    accessToken: apikey
		}).addTo(mymap);

  	 	//add marker
  	 	var marker = L.marker([-6.173110,106.829361]).addTo(mymap);
  	 	marker.bindPopup("<b>Hello world!</b><br>I am a popup.");

  	 	L.geoJson(indoData).addTo(mymap);

  	 </script>
    
    
  </div>
</div>



@endsection