<div id="map"></div>
<script type="text/javascript">
/*add cluster marker*/
var apikey = 'pk.eyJ1IjoiY2hhbmRyYWRhcm1hd2FuMTciLCJhIjoiY2s5OGp6MWxxMDJ6bDNtbW5ndWtpeTR1MiJ9.dOWewSSFZpkoosXlkf99Pg';
var cloudmade = new L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  maxZoom: 18,
  id: 'mapbox/light-v9',
  tileSize: 512,
  zoomOffset: -1,
  accessToken: apikey
});

var lat  = -0.789275;
var long = 113.9213257;
var latlng = new L.LatLng(lat, long);

var map = new L.Map('map', {center: latlng, zoom: 5, layers: [cloudmade]});

var markers = new L.MarkerClusterGroup();
var markersList = [];

/*get data user report*/
var url = location.origin+'/get_report_conf/'+{{$conf}};
$.ajax({
  url:url,
  method:"GET",
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  dataType:"json",
  success:function(data)
  { 
      console.log(data);
      $.each( data, function( key, value ) {
          var m = new L.Marker(new L.LatLng(value.geometry_lat,value.geometry_lng));
          m.bindPopup("<b>"+value.name+"</b><br>"+value.geometry_desc+".");
          markersList.push(m);
          markers.addLayer(m);
      });
  }
});

map.addLayer(markers);
/*end cluster marker*/
// L.geoJson(indoData).addTo(map);
/*end map*/
</script>